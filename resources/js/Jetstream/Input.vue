<template>
    <input
        class="
            ring-4 ring-indigo-300 ring-opacity-20
            border-gray-300
            focus:border-indigo-300
            focus:ring
            focus:ring-indigo-200
            focus:ring-opacity-50
            rounded-md
            shadow-sm
        "
        :value="value"
        @input="$emit('input', $event.target.value)"
        ref="input"
    />
</template>

<script>
export default {
    props: ["value"],

    methods: {
        focus() {
            this.$refs.input.focus();
        },
    },
};
</script>
