<template>
    <div class="md:pl-10 pt-5 pb-5" @mouseover="showReplyButton = true" @mouseleave="showReplyButton = false">
        <h6 class="text-xl text-gray-400 underline">
            {{ reply.user_name }}
            <p class="md:inline md:pl-10 no-underline text-gray-500">{{ reply.created_at_humanized }}</p>
        </h6>
        <p class="text-gray-600 pt-8">
            {{ reply.body }}
        </p>

        <div class="float-right" v-if="showReplyButton && showReplyForm == false" @click="showReplyForm = !showReplyForm">
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24"
                class="inline-block text-md mr-2" height="1em" width="1em"
                xmlns="http://www.w3.org/2000/svg">
                <path fill="none" d="M0 0h24v24H0z"></path>
                <path d="M10 9V5l-7 7 7 7v-4.1c5 0 8.5 1.6 11 5.1-1-5-4-10-11-11z"></path>
            </svg>
            <span class="cursor-pointer">Reply</span>
        </div>
        
        <form class="flex md:pl-10" v-if="showReplyForm" @submit.prevent="addSubReply">
            <input 
                type="text" 
                placeholder="Enter name here" 
                class="mt-3 mr-2 border-box border-2 border-slate-300 px-1 py-1 rounded"
                v-model="userName"
            />
            <input 
                type="text" 
                placeholder="Enter reply here" 
                class="w-full mt-3 mr-2 border-box border-2 border-slate-300 px-1 py-1 rounded"
                v-model="body"
            />
            <button class="px-5 bg-brightBlue text-xl text-white mt-3 font-bold rounded" :disabled="showSpinner">
                <template v-if="showSpinner">
                    <svg role="status" class="inline mr-3 w-4 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                    </svg>
                    Loading...
                </template>
                <template v-else>Submit</template>
            </button>
        </form>

        <div class="flex md:pl-10">
            <small v-for="(error, index) in errors.user_name" :key="'user_name_index' + index" class="w-full form-text text-danger">{{ error }}</small>
            <small v-for="(error, index) in errors.body" :key="'body_index' + index" class="w-full form-text text-danger">{{ error }}</small>
        </div>

        <sub-reply v-for="(subReply, subReplyIndex) in reply.sub_replies" :key="subReplyIndex" :subReply=subReply></sub-reply>
    </div>
</template>

<script>
export default {
    props: {
        reply: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            showReplyButton: false,
            showSpinner: false,
            showReplyForm: false,
            userName: null,
            body: null,
            errors: {
                user_name: [],
                body: [],
            },
        }
    },
    methods: {
        addSubReply() {
            this.loadSpinner()

            let formData = {
                user_name: this.userName,
                body: this.body
            }

            axios({url: `/api/replies/${this.reply.id}`, method: 'POST', data: formData })
            .then(response => {
                let apiResponse = response.data

                this.errors = []
                this.refreshSubReplies()
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
        refreshSubReplies() {
            axios({url: `/api/replies/${this.reply.id}`, method: 'GET'})
            .then(response => {
                let apiResponse = response.data

                this.reply.sub_replies = apiResponse.data.sub_replies.data
                this.stopSpinner()
                this.showReplyForm = false
                this.resetForm()
            })
            .catch(error => {
                this.stopSpinner()

                alert("an error occurred, kindly refresh the tab")
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