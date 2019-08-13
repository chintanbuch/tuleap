/*
 * Copyright (c) Enalean, 2019-Present. All Rights Reserved.
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

export const edit_modal_mixin = {
    props: {
        project_id: {
            type: String,
            required: true
        },
        minimal_rank: {
            type: Number,
            required: true
        },
        csrf_token: {
            type: String,
            required: true
        },
        csrf_token_name: {
            type: String,
            required: true
        },
        allowed_icons: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            service: this.resetService()
        };
    },
    computed: {
        form_url() {
            return `/project/${encodeURIComponent(this.project_id)}/admin/services/edit`;
        }
    },
    methods: {
        show(button) {
            this.service = JSON.parse(button.dataset.serviceJson);
            this.$refs.modal.show();
        },
        resetModal() {
            this.service = this.resetService();
        },
        resetService() {
            return {
                id: null,
                icon_name: "",
                label: "",
                link: "",
                description: "",
                is_active: true,
                is_used: true,
                is_in_iframe: false,
                rank: this.minimal_rank,
                is_project_scope: true
            };
        }
    }
};
