/*
 * Copyright (c) Enalean, 2019 - present. All Rights Reserved.
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

import { shallowMount } from "@vue/test-utils";
import ParentCard from "./ParentCard.vue";
import { createStoreMock } from "@tuleap-vue-components/store-wrapper-jest";

jest.useFakeTimers();

describe("ParentCard", () => {
    it("displays a parent card", () => {
        const wrapper = shallowMount(ParentCard, {
            mocks: {
                $store: createStoreMock({ state: { user: { user_has_accessibility_mode: false } } })
            },
            propsData: {
                card: {
                    id: 43,
                    color: "lake-placid-blue",
                    background_color: "fiesta-red",
                    assignees: [],
                    initial_effort: 666,
                    remaining_effort: 333
                }
            }
        });
        expect(wrapper.element).toMatchSnapshot();
    });

    it("doesn't add a dummy taskboard-card-background- class if the card has no background color", () => {
        const wrapper = shallowMount(ParentCard, {
            mocks: {
                $store: createStoreMock({ state: { user: { user_has_accessibility_mode: false } } })
            },
            propsData: {
                card: {
                    id: 43,
                    color: "lake-placid-blue",
                    background_color: "",
                    assignees: [],
                    initial_effort: 666,
                    remaining_effort: 333
                }
            }
        });
        expect(wrapper.classes()).not.toContain("taskboard-card-background-");
    });

    it("adds accessibility class if user needs it and card has a background color", () => {
        const wrapper = shallowMount(ParentCard, {
            mocks: {
                $store: createStoreMock({ state: { user: { user_has_accessibility_mode: true } } })
            },
            propsData: {
                card: {
                    id: 43,
                    color: "lake-placid-blue",
                    background_color: "fiesta-red",
                    assignees: [],
                    initial_effort: 666,
                    remaining_effort: 333
                }
            }
        });
        expect(wrapper.contains(".taskboard-card-accessibility")).toBe(true);
        expect(wrapper.classes()).toContain("taskboard-card-with-accessibility");
    });

    it("does not add accessibility class if user needs it but card has no background color", () => {
        const wrapper = shallowMount(ParentCard, {
            mocks: {
                $store: createStoreMock({ state: { user: { user_has_accessibility_mode: true } } })
            },
            propsData: {
                card: {
                    id: 43,
                    color: "lake-placid-blue",
                    background_color: "",
                    assignees: [],
                    initial_effort: 666,
                    remaining_effort: 222
                }
            }
        });
        expect(wrapper.contains(".taskboard-card-accessibility")).toBe(false);
        expect(wrapper.classes()).not.toContain("taskboard-card-with-accessibility");
    });

    it("removes the show classes after 500ms", () => {
        const wrapper = shallowMount(ParentCard, {
            mocks: {
                $store: createStoreMock({ state: { user: { user_has_accessibility_mode: false } } })
            },
            propsData: {
                card: {
                    id: 43,
                    color: "lake-placid-blue",
                    background_color: "fiesta-red",
                    assignees: [],
                    initial_effort: 666,
                    remaining_effort: 333
                }
            }
        });
        jest.runAllTimers();
        expect(setTimeout).toHaveBeenCalledWith(expect.any(Function), 500);
        expect(wrapper.classes()).not.toContain("taskboard-card-show");
    });
});