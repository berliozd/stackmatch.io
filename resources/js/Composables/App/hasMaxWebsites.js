import axios from "axios";
import {usePage} from "@inertiajs/vue3";

export default async function hasMaxWebsites() {
    if (usePage().props.subscription && usePage().props.subscription.is_valid) {
        return false
    }
    const url = '/api/websites/list'
    const response = await axios.get(url)
    return response.data.length >= usePage().props.app.nb_free_websites
}
