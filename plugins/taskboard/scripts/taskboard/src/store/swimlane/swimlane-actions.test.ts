/*
 * Copyright (c) Enalean, 2019 - Present. All Rights Reserved.
 *
 * This file is a part of Tuleap.
 *
 * Tuleap is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Tuleap is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Tuleap. If not, see <http://www.gnu.org/licenses/>.
 */

import { Card, CardPosition, ColumnDefinition, Direction, Swimlane } from "../../type";
import * as tlp from "tlp";
import { RecursiveGetInit } from "tlp";
import * as actions from "./swimlane-actions";
import { loadChildrenCards } from "./swimlane-actions";
import { ActionContext } from "vuex";
import { MoveCardsPayload, ReorderCardsPayload, SwimlaneState } from "./type";
import { mockFetchSuccess } from "../../../../../../../src/www/themes/common/tlp/mocks/tlp-fetch-mock-helper";
import { RootState } from "../type";

jest.mock("tlp");

describe("Swimlane state actions", () => {
    let context: ActionContext<SwimlaneState, RootState>;
    let tlpRecursiveGetMock: jest.SpyInstance;

    beforeEach(() => {
        context = ({
            commit: jest.fn(),
            dispatch: jest.fn(),
            getters: {
                is_drop_accepted_in_target: (): boolean => true
            },
            rootState: {
                milestone_id: 42,
                user: {
                    user_id: 101
                }
            } as RootState
        } as unknown) as ActionContext<SwimlaneState, RootState>;
        tlpRecursiveGetMock = jest.spyOn(tlp, "recursiveGet");
    });

    describe(`loadSwimlanes`, () => {
        it("Retrieves all top-level cards of the taskboard", async () => {
            await actions.loadSwimlanes(context);
            expect(context.commit).toHaveBeenCalledWith("beginLoadingSwimlanes");
            expect(context.commit).toHaveBeenCalledWith("endLoadingSwimlanes");
            expect(tlpRecursiveGetMock).toHaveBeenCalledWith(`/api/v1/taskboard/42/cards`, {
                params: { limit: 100 },
                getCollectionCallback: expect.any(Function)
            });
        });

        it("Stores the new swimlanes", async () => {
            tlpRecursiveGetMock = jest.spyOn(tlp, "recursiveGet").mockImplementation(
                <T>(url: string, init?: RecursiveGetInit<Card[], T>): Promise<T[]> => {
                    if (!init || !init.getCollectionCallback) {
                        throw new Error();
                    }

                    return Promise.resolve(
                        init.getCollectionCallback([{ id: 43 } as Card, { id: 44 } as Card])
                    );
                }
            );
            await actions.loadSwimlanes(context);
            expect(context.commit).toHaveBeenCalledWith("addSwimlanes", [
                {
                    card: {
                        id: 43,
                        is_in_edit_mode: false,
                        is_being_saved: false,
                        is_just_saved: false
                    },
                    children_cards: [] as Card[],
                    is_loading_children_cards: false
                } as Swimlane,
                {
                    card: {
                        id: 44,
                        is_in_edit_mode: false,
                        is_being_saved: false,
                        is_just_saved: false
                    },
                    children_cards: [] as Card[],
                    is_loading_children_cards: false
                } as Swimlane
            ]);
        });

        it(`when top-level cards have children, it will load their children`, async () => {
            const card_with_children = {
                id: 43,
                has_children: true
            } as Card;
            const other_card_with_children = {
                id: 44,
                has_children: true
            } as Card;
            const card_without_children = {
                id: 45,
                has_children: false
            } as Card;
            tlpRecursiveGetMock = jest.spyOn(tlp, "recursiveGet").mockImplementation(
                <T>(url: string, init?: RecursiveGetInit<Card[], T>): Promise<T[]> => {
                    if (!init || !init.getCollectionCallback) {
                        throw new Error();
                    }

                    return Promise.resolve(
                        init.getCollectionCallback([
                            card_with_children,
                            other_card_with_children,
                            card_without_children
                        ])
                    );
                }
            );
            await actions.loadSwimlanes(context);
            expect(context.dispatch).toHaveBeenCalledWith(
                "loadChildrenCards",
                expect.objectContaining({
                    card: {
                        ...card_with_children,
                        is_in_edit_mode: false,
                        is_being_saved: false,
                        is_just_saved: false
                    }
                })
            );
            expect(context.dispatch).toHaveBeenCalledWith(
                "loadChildrenCards",
                expect.objectContaining({
                    card: {
                        ...other_card_with_children,
                        is_in_edit_mode: false,
                        is_being_saved: false,
                        is_just_saved: false
                    }
                })
            );
            expect(context.dispatch).not.toHaveBeenCalledWith(
                "loadChildrenCards",
                expect.objectContaining({
                    card: {
                        ...card_without_children,
                        is_in_edit_mode: false,
                        is_being_saved: false,
                        is_just_saved: false
                    }
                })
            );
        });

        it(`When there is a REST error, it will stop the loading flag and will show a global error`, async () => {
            const error = new Error();
            tlpRecursiveGetMock.mockRejectedValue(error);
            await actions.loadSwimlanes(context);
            expect(context.dispatch).toHaveBeenCalledTimes(1);
            expect(context.dispatch).toHaveBeenCalledWith("error/handleGlobalError", error, {
                root: true
            });
            expect(context.commit).toHaveBeenCalledWith("endLoadingSwimlanes");
        });
    });

    describe(`loadChildrenCards`, () => {
        let swimlane: Swimlane;
        beforeEach(() => {
            swimlane = {
                card: { id: 197 } as Card,
                children_cards: [],
                is_loading_children_cards: false
            };
        });

        it(`Retrieves all children cards of a top-level card`, async () => {
            await actions.loadChildrenCards(context, swimlane);

            expect(context.commit).toHaveBeenCalledWith("beginLoadingChildren", swimlane);
            expect(context.commit).toHaveBeenCalledWith("endLoadingChildren", swimlane);
            expect(tlpRecursiveGetMock).toHaveBeenCalledWith(
                "/api/v1/taskboard_cards/197/children",
                {
                    params: {
                        milestone_id: 42,
                        limit: 100
                    },
                    getCollectionCallback: expect.any(Function)
                }
            );
        });

        it(`Adds the new children cards to the swimlane in the store`, async () => {
            const children_cards = [{ id: 43 } as Card, { id: 44 } as Card];
            tlpRecursiveGetMock = jest.spyOn(tlp, "recursiveGet").mockImplementation(
                <T>(url: string, init?: RecursiveGetInit<Card[], T>): Promise<Array<T>> => {
                    if (!init || !init.getCollectionCallback) {
                        throw new Error();
                    }

                    return Promise.resolve(init.getCollectionCallback(children_cards));
                }
            );

            await actions.loadChildrenCards(context, swimlane);
            expect(context.commit).toHaveBeenCalledWith("addChildrenToSwimlane", {
                swimlane,
                children_cards
            });
        });

        it(`When there is a REST error, it will stop the loading flag and will show an error modal`, async () => {
            const error = new Error();
            tlpRecursiveGetMock.mockRejectedValue(error);
            await loadChildrenCards(context, swimlane);
            expect(context.dispatch).toHaveBeenCalledWith("error/handleModalError", error, {
                root: true
            });
            expect(context.commit).toHaveBeenCalledWith("endLoadingChildren", swimlane);
        });
    });

    describe("expandSwimlane", () => {
        it(`When the swimlane is expanded, the user pref is stored`, async () => {
            const swimlane: Swimlane = {
                card: { id: 69 } as Card
            } as Swimlane;

            const tlpDeleteMock = jest.spyOn(tlp, "del");
            mockFetchSuccess(tlpDeleteMock, {});

            await actions.expandSwimlane(context, swimlane);
            expect(context.commit).toHaveBeenCalledWith("expandSwimlane", swimlane);
            expect(context.dispatch).toHaveBeenCalledWith(
                "user/deletePreference",
                { key: "plugin_taskboard_collapse_42_69" },
                { root: true }
            );
        });
    });

    describe("collapseSwimlane", () => {
        it(`When the swimlane is collapsed, the user pref is stored`, async () => {
            const swimlane: Swimlane = {
                card: { id: 69 } as Card
            } as Swimlane;

            const tlpPatchMock = jest.spyOn(tlp, "patch");
            mockFetchSuccess(tlpPatchMock, {});

            await actions.collapseSwimlane(context, swimlane);
            expect(context.commit).toHaveBeenCalledWith("collapseSwimlane", swimlane);
            expect(context.dispatch).toHaveBeenCalledWith(
                "user/setPreference",
                { key: "plugin_taskboard_collapse_42_69", value: "1" },
                { root: true }
            );
        });
    });

    describe("reorderCardsInCell", () => {
        const card_to_move = { id: 102, tracker_id: 7, mapped_list_value: { id: 49 } } as Card;
        const swimlane: Swimlane = {
            card: { id: 86 },
            children_cards: [
                { id: 100, tracker_id: 7, mapped_list_value: { id: 49 } } as Card,
                card_to_move
            ]
        } as Swimlane;

        const column: ColumnDefinition = {
            id: 42
        } as ColumnDefinition;

        const position: CardPosition = {
            ids: [card_to_move.id],
            direction: Direction.BEFORE,
            compared_to: 100
        };

        const payload = {
            swimlane,
            column,
            position
        } as ReorderCardsPayload;

        it("The new position of the card is stored and the cards are reorderd", async () => {
            const tlpPatchMock = jest.spyOn(tlp, "patch");
            mockFetchSuccess(tlpPatchMock, {});
            await actions.reorderCardsInCell(context, payload);

            expect(tlpPatchMock).toHaveBeenCalledWith(`/api/v1/taskboard_cells/86/column/42`, {
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    order: {
                        ids: [102],
                        direction: "before",
                        compared_to: 100
                    }
                })
            });

            expect(context.commit).toHaveBeenCalledWith("changeCardPosition", payload);
        });

        it("A modal opens on error", async () => {
            const error = new Error();

            const tlpPatchMock = jest.spyOn(tlp, "patch");
            tlpPatchMock.mockRejectedValue(error);

            await actions.reorderCardsInCell(context, payload);

            expect(context.dispatch).toHaveBeenCalledWith("error/handleModalError", error, {
                root: true
            });
        });
    });

    describe("moveCardToCell", () => {
        let card_to_move: Card,
            swimlane: Swimlane,
            column: ColumnDefinition,
            payload: MoveCardsPayload;

        beforeEach(() => {
            card_to_move = { id: 102, tracker_id: 7, mapped_list_value: { id: 49 } } as Card;
            swimlane = {
                card: { id: 86 },
                children_cards: [
                    { id: 100, tracker_id: 7, mapped_list_value: { id: 49 } } as Card,
                    card_to_move
                ]
            } as Swimlane;

            column = {
                id: 42
            } as ColumnDefinition;

            payload = {
                swimlane,
                column,
                card: card_to_move
            } as MoveCardsPayload;
        });

        it("The new column of the card is stored", async () => {
            const tlpPatchMock = jest.spyOn(tlp, "patch");
            mockFetchSuccess(tlpPatchMock, {});

            await actions.moveCardToCell(context, payload);

            expect(tlpPatchMock).toHaveBeenCalledWith(`/api/v1/taskboard_cells/86/column/42`, {
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    add: card_to_move.id
                })
            });

            expect(context.commit).toHaveBeenCalledWith("moveCardToColumn", payload);
        });

        it("When the payload has a position, it will add it to the REST payload", async () => {
            const tlpPatchMock = jest.spyOn(tlp, "patch");
            mockFetchSuccess(tlpPatchMock, {});

            const position: CardPosition = {
                ids: [card_to_move.id],
                direction: Direction.BEFORE,
                compared_to: 100
            };

            Object.assign(payload, { position });

            await actions.moveCardToCell(context, payload);

            expect(tlpPatchMock).toHaveBeenCalledWith(`/api/v1/taskboard_cells/86/column/42`, {
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    add: card_to_move.id,
                    order: {
                        ids: [102],
                        direction: "before",
                        compared_to: 100
                    }
                })
            });

            expect(context.commit).toHaveBeenCalledWith("moveCardToColumn", payload);
        });

        it("A modal opens on error", async () => {
            const error = new Error();

            const tlpPatchMock = jest.spyOn(tlp, "patch");
            tlpPatchMock.mockRejectedValue(error);

            await actions.moveCardToCell(context, payload);

            expect(context.dispatch).toHaveBeenCalledWith("error/handleModalError", error, {
                root: true
            });
        });
    });
});
