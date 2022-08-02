<template>
    <div class="md:pl-20 pt-5 my-8">
        <h6 class="text-xl text-gray-400 underline">
            {{ subReply.user_name }}
            <p class="md:inline md:pl-10 no-underline text-gray-500">{{ subReply.created_at_humanized }}</p>
        </h6>
        <p class="text-gray-600 pt-8">
            {{ subReply.body }}
        </p>
    </div>
</template>

<script>
export default {
    props: {
        subReply: {
            type: Object,
            required: true
        }
    }
}
</script>