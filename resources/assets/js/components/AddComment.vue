<template>
    <section class="md:px-48 px-8 mb-10">
        <div id="comments" class="pt-8 md:pl-10">
            <div class="bg-white  p-10 rounded mx-5 ">
                <h3 class="text-2xl font-bold pt-3 md:text-3xl">
                    Add a Comment
                </h3>

                <form @submit.prevent="addComment">
                    <label for="user_name"></label>
                    <input 
                        type="text" 
                        placeholder="Enter name here" 
                        class="w-full mt-3 border-box border-2 border-slate-500 px-3 py-3 rounded"
                        v-model="userName"
                    />
                    <small v-for="(error, index) in errors.user_name" :key="'user_name_index' + index" class="form-text text-danger">{{ error }}</small>

                    <label for="body"></label>
                    <textarea 
                        cols="10" 
                        rows="6" 
                        placeholder="Write your comment here..."
                        v-model="body"
                        class="w-full mt-3 border-box border-2 border-slate-500 px-3 py-3 rounded"></textarea>

                    <small v-for="(error, index) in errors.body" :key="'body_index' + index" class="form-text text-danger">{{ error }}</small>

                    <div>
                        <button
                            class="bg-brightBlue text-xl text-white mt-3 py-5 px-10 font-bold rounded inline"
                            :disabled="showSpinner"
                        >
                            <template v-if="showSpinner">
                                <svg role="status" class="inline mr-3 w-4 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                </svg>
                                Loading...
                            </template>
                            <template v-else>SEND</template>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        data() {
            return {
                showSpinner: false,
                userName: null,
                body: null,
                errors: {
                    user_name: [],
                    body: [],
                },
            }
        },
        methods: {
            addComment() {
                this.loadSpinner()
                let formData = {
                    user_name: this.userName,
                    body: this.body
                }

                axios({url: `/api/comments`, method: 'POST', data: formData })
                .then(response => {
                    let apiResponse = response.data

                    this.$toastr.s(
                        "Comment added 🎉"
                    );

                    this.$emit('addedNewComment')
                    this.stopSpinner()
                    this.resetForm()
                    this.resetErrorBag()
                })
                .catch(error => {
                    this.stopSpinner()

                    if (error.response) {
                        let apiData = error.response.data
                        console.log(apiData)
                        this.errors.user_name = apiData.data.user_name
                        this.errors.body = apiData.data.body
                    } else {
                        console.log(error)
                    }
                })
            },
            resetForm() {
                this.userName = null 
                this.body =null
            },
            resetErrorBag() {
                this.errors.user_name = []
                this.errors.body = []
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
