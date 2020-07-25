import { flash } from "@js/flash"
import { lazyc } from "@vue/utils"
import { asSequence } from "sequency"
import Vue from "$vue"

(() => {
	document.addEventListener("DOMContentLoaded", () => {
		console.log(flash);
		const components = asSequence(["App", "QuoteCard"])
		.map(e => ({[e]: lazyc(e)}))
		.reduce(Object.assign);

		new Vue({
			el: "#app",
			components
		});
	});
})();