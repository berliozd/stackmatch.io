import axios from "axios";
import {usePage} from "@inertiajs/vue3";

export default async function hasMaxWebsites() {
    // return true
    if (usePage().props.auth.subscription && usePage().props.auth.subscription.is_valid) {
        return false
    }
    const url = '/api/websites/list'
    const response = await axios.get(url)
    console.log(response.data.length);
    console.log(usePage().props.app.nb_free_websites);
    return response.data.length >= usePage().props.app.nb_free_websites
}
