<template>
    <section class="">
        <section class="comments px-8 md:px-48 p-20">
            <hr class="block my-2 mx-auto  border-stone-600">

            <h3 class="text-2xl font-bold pt-3 md:text-3xl">
                Leave a comment below
            </h3>

            <h3 class="text-2xl font-bold pt-10 text-gray-700 md:text-3xl">
                Comments
            </h3>

            <comment-spinner v-if="showSpinner"></comment-spinner>

            <comment v-else v-for="(comment, index) in comments.data" :key="index" :comment=comment></comment>
        </section>

        <add-comment @addedNewComment="getComments()"></add-comment>
    </section>
</template>

<script>
    export default {
        mounted() {
            this.getComments() 
        },
        data() {
            return {
                showSpinner: false,
                comments: [],
            }
        },
        methods: {
            getComments() {
                this.loadSpinner()

                axios({url: `/api/comments`, method: 'GET'})
                .then(response => {
                    let apiResponse = response.data
                    console.log(apiResponse)

                    this.comments = apiResponse.data.comments

                    this.stopSpinner()
                })
                .catch(error => {
                    this.stopSpinner()
                    console.log(error)

                    alert('An error occurred while fetching comments')
                })
            },
            loadSpinner() {
                this.showSpinner = true
            },
            stopSpinner() {
                this.showSpinner = false
            }
        }
    }
</script>
