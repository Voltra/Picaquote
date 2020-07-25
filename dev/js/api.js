import { $json } from "@voltra/json"
import Cookie from "js-cookie"


const api = {
	get: {},
	post: {
		editQuote: (id, quote) => $json.post(`/admin/editQuote/${id}`, { quote }),
		newQuote: quote => $json.post("/admin/newQuote", { quote })
	}
};

export {
	api,
}