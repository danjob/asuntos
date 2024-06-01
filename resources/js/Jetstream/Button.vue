<template>
    <button
        :type="type"
        class="
            inline-flex
            items-center
            px-4
            py-2
            border border-transparent
            rounded-md
            font-semibold
            text-xs text-white
            uppercase
            tracking-widest
            hover:bg-gray-100
            active:bg-gray-100
            focus:outline-none focus:border-gray-900 focus:shadow-outline-gray
            transition
            ease-in-out
            duration-150
            text-xl
        "
    >
        <slot></slot>
    </button>
</template>

<script>
export default {
    props: {
        type: {
            type: String,
            default: "submit",
        },
    },
};
</script>
