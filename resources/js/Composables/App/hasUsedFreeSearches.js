import axios from "axios";
import {usePage} from "@inertiajs/vue3";

export default async function hasUsedFreeSearches() {
    // return true
    if (usePage().props.subscription && usePage().props.subscription.is_valid) {
        return false
    }
    const userResponse = await axios.get('/api/user')
    return userResponse.data.nb_searches >= usePage().props.app.nb_free_searches
}
