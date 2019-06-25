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

import {
    getNbOfBacklogItems as getBacklogs,
    getNbOfUpcomingReleases as getReleases
} from "../api/rest-querier.js";

export async function getNumberOfBacklogItems(context) {
    context.commit("resetErrorMessage");
    const total = await getBacklogs(
        context.state.project_id,
        context.state.pagination_limit,
        context.state.pagination_offset
    );
    return context.commit("setNbBacklogItem", total);
}

export async function getNumberOfUpcomingReleases(context) {
    context.commit("resetErrorMessage");
    const total = await getReleases(
        context.state.project_id,
        context.state.pagination_limit,
        context.state.pagination_offset
    );
    return context.commit("setNbUpcomingReleases", total);
}

export async function getTotalsBacklogAndUpcomingReleases(context) {
    try {
        context.commit("setIsLoading", true);
        await getNumberOfUpcomingReleases(context);
        await getNumberOfBacklogItems(context);
    } catch (error) {
        await handleErrorMessage(context, error);
    } finally {
        context.commit("setIsLoading", false);
    }
}

async function handleErrorMessage(context, rest_error) {
    try {
        const { error } = await rest_error.response.json();
        context.commit("setErrorMessage", error.code + " " + error.message);
    } catch (error) {
        context.commit("setErrorMessage", "");
    }
}