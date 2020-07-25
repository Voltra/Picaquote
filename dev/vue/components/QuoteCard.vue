<template>
    <div class="quote">
        <p class="content">
            &laquo;&nbsp; {{ content }} &nbsp;&raquo;
        </p><br/>
        <p v-if="sign" class="sign">- Picarougne 2019</p>
        <p v-if="subtext" class="subtext">{{ subtext }}</p>
    </div>
</template>

<script>
	export default {
		name: "quote-card",
        props: {
			sign: {
				type: Boolean,
                default: false
            },
			content: {
				type: String,
                required: true
            },
            subtext: {
				type: String,
                default: null
            }
        }
	}
</script>

<style lang="scss" scoped>
    @import "~@css/quote_card/quote_card";
</style>