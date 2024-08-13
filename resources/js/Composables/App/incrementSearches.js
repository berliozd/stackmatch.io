import axios from "axios";
import {usePage} from "@inertiajs/vue3";

const userId = () => {
    return usePage().props.auth.user.id
}

export default async function hasUsedFreeSearches() {
    const userResponse = await axios.get('/api/user')
    let nbSearches = userResponse.data.nb_searches
    await axios.patch('/api/user/' + userId(), {'field': 'nb_searches', 'value': ++nbSearches})
}
