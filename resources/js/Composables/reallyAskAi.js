import axios from "axios";

export async function askContactEmailContent(name) {
    return await axios.post(
        '/api/ai/contact_email/',
        {'name': name}
    ).then(
        (response) => {
            return response.data.response
        }
    )
}
