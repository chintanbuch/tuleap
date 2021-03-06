/*
 * Copyright (c) Enalean, 2020 - present. All Rights Reserved.
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

import { shallowMount, Wrapper } from "@vue/test-utils";
import FieldTrackerTemplateId from "./FieldTrackerTemplateId.vue";
import { State } from "../../../../store/type";
import { createStoreMock } from "../../../../../../../../../src/www/scripts/vue-components/store-wrapper-jest";

describe("FieldTrackerTemplateId", () => {
    function getWrapper(is_a_duplication: boolean): Wrapper<FieldTrackerTemplateId> {
        return shallowMount(FieldTrackerTemplateId, {
            mocks: {
                $store: createStoreMock({
                    state: {
                        selected_tracker_template: {
                            id: "100",
                            name: "bugs"
                        },
                        selected_project_tracker_template: {
                            id: "101",
                            name: "Kanban"
                        }
                    } as State,
                    getters: {
                        is_a_duplication
                    }
                })
            }
        });
    }

    it("If it is a duplication, then it sets the input value with the selected tracker id", () => {
        const wrapper = getWrapper(true);
        const input: HTMLInputElement = wrapper.element as HTMLInputElement;

        expect(input.value).toEqual("100");
    });

    it("sets the input value with the selected project tracker id", () => {
        const wrapper = getWrapper(false);
        const input: HTMLInputElement = wrapper.element as HTMLInputElement;

        expect(input.value).toEqual("101");
    });
});
