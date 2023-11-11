<template>
    <div>
        <div class="px-5 py-3 border-b border-lighter flex items-center justify-between">
            <h1 class="text-xl font-bold">Home</h1>
            <i class="far fa-star text-xl text-blue"></i>
        </div>

        <div class="px-5 py-3 border-b-8 border-lighter flex">
            <div class="flex-none">
                <img :src="user.profile" class="flex-none w-12 h-12 rounded-full border border-lighter"/>
            </div>
            <form class="w-full px-4 relative">
                <textarea id="tweet" name="tweet" v-model="fields.tweet" placeholder="What's up?"
                          class="mt-3 pb-3 w-full focus:outline-none" v-validate="fieldsValidation.tweet"/>
                <span class="mt-2 text-sm text-red-600 dark:text-red-500">{{ errors.first('tweet') }}</span>
                <button v-if="loading"
                        class="h-10 px-4 bg-blue-300 hover:bg-blue-700 text-white font-bold rounded-full absolute bottom-0 right-0"
                        style="background-color: rgb(29, 155, 240);">
                    Processing <i class="fa fa-spinner fa-spin"></i>
                </button>
                <button @click.prevent="handleAddTweet" v-else
                        class="h-10 px-4 bg-blue-300 hover:bg-blue-700 text-white font-bold rounded-full absolute bottom-0 right-0"
                        style="background-color: rgb(29, 155, 240);">
                    POST
                </button>
            </form>
        </div>

        <div v-for="(tweet, index) in tweets" :key="index" class="w-full p-4 border-b hover:bg-lighter flex">
            <div class="flex-none mr-4">
                <img :src="`${tweet.profile}`" class="h-12 w-12 rounded-full flex-none"/>
            </div>
            <div class="w-full">
                <div class="flex items-center w-full">
                    <p class="font-semibold"> {{ tweet.name }} </p>
                    <p class="text-sm text-dark ml-2"> {{ tweet.handle }} </p>
                    <p class="text-sm text-dark ml-2"> {{ tweet.time }} </p>
                </div>
                <p class="py-2">
                    {{ tweet.tweet }}
                </p>
                <div class="flex items-center justify-between w-full">
                    <div class="flex items-center text-sm text-dark">
                        <a href="javascript:void(0)" v-if="tweet.liked === false" @click.prevent="handleStorePostLike(index)">
                            <i class="fas fa-heart mr-3"></i> {{ tweet.like }}
                        </a>
                        <span v-else>
                            <i class="fas fa-heart mr-3" style="color: red"></i> {{ tweet.like }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import * as VeeValidate from 'vee-validate';

let veeCustomMessage = {
    en: {
        custom: {
            tweet: {
                required: 'Tweet field is required',
            }
        }
    }
};

let tweetObj = {
    tweet: ''
};

Vue.use(VeeValidate, {
    dictionary: veeCustomMessage,
    fieldsBagName: tweetObj
});
export default {
    name: 'Home',
    data() {
        return {
            fields: tweetObj,
            fieldsValidation: {
                tweet: {
                    required: true,
                    min: 10,
                    max: 200
                },
            },
            user: {},
            tweets: [],
            loading: false
        }
    },
    methods: {
        handleAddTweet() {
            this.$validator.validateAll().then((result) => {
                if (result) {
                    this.loading = true;
                    let form = new FormData();
                    form.append('tweet', this.fields.tweet);
                    axios.post(`${this.$env.BACKEND_API}/api/v1/tweet/store`, form)
                        .then(res => {
                            this.$notification.notify(this, 'Success', res.data.message);
                            let response = res.data.data;
                            let obj = {};
                            obj.tweet = response.tweet;
                            obj.uuid = response.uuid;
                            obj.like = response.like;
                            obj.liked = response.liked;
                            obj.time = response.ago;
                            obj.name = response.creator.name;
                            obj.username = response.creator.username;
                            obj.profile = response.creator.image;
                            this.tweets.splice(0, 0, obj);
                            this.loading = false;
                            this.fields.tweet = '';
                        })
                        .catch(err => {
                            this.loading = false;
                            if (err.response.status === 422) {
                                this.$notification.error(this, 'Error', err.response.data.errors['tweet'][0]);
                            }
                        })
                }
            });
        },
        handleGetUserObject() {
            this.user = this.$localStorage.get('user');
        },
        handleGetAllTweet() {
            axios.get(`${this.$env.BACKEND_API}/api/v1/tweet/list`)
                .then(res => {
                    let response = res.data;
                    response.forEach(item => {
                        let obj = {};
                        obj.tweet = item.tweet;
                        obj.uuid = item.uuid;
                        obj.like = item.like;
                        obj.liked = item.liked;
                        obj.time = item.ago;
                        obj.name = item.creator.name;
                        obj.username = item.creator.username;
                        obj.profile = item.creator.image;
                        this.tweets.push(obj)
                    })
                })
                .catch(err => {
                    console.log(err)
                })
        },
        handleStorePostLike(key) {
            this.tweets[key].like = this.tweets[key].like + 1;
            this.tweets[key].liked = true;
            axios.post(`${this.$env.BACKEND_API}/api/v1/tweet/${this.tweets[key].uuid}/like`)
                .then(res => {
                    console.log(res.data);
                })
                .catch(err => {
                    console.log(err.response);
                })
        }
    },
    mounted() {
        this.handleGetUserObject();
        this.handleGetAllTweet();
    }
}
</script>
