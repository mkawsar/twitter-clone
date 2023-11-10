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
            <form v-on:submit.prevent="addTweet" class="w-full px-4 relative">
                <textarea v-model="tweet.text" placeholder="What's up?" class="mt-3 pb-3 w-full focus:outline-none"/>
                <div class="flex items-center">
                    <i class="text-lg text-blue mr-4 far fa-image"></i>
                    <i class="text-lg text-blue mr-4 fas fa-film"></i>
                    <i class="text-lg text-blue mr-4 far fa-chart-bar"></i>
                    <i class="text-lg text-blue mr-4 far fa-smile"></i>
                </div>
                <button
                    class="h-10 px-4 bg-blue-300 hover:bg-blue-700 text-white font-bold rounded-full absolute bottom-0 right-0"
                    style="background-color: rgb(29, 155, 240);">
                    POST
                </button>
            </form>
        </div>

        <div v-for="(follow,index) in following" :key="index" class="w-full p-4 border-b hover:bg-lighter flex">
            <div class="flex-none mr-4">
                <img :src="`${follow.src}`" class="h-12 w-12 rounded-full flex-none"/>
            </div>
            <div class="w-full">
                <div class="flex items-center w-full">
                    <p class="font-semibold"> {{ follow.name }} </p>
                    <p class="text-sm text-dark ml-2"> {{ follow.handle }} </p>
                    <p class="text-sm text-dark ml-2"> {{ follow.time }} </p>
                    <i class="fas fa-angle-down text-dark ml-auto"></i>
                </div>
                <p class="py-2">
                    {{ follow.tweet }}
                </p>
                <div class="flex items-center justify-between w-full">
                    <div class="flex items-center text-sm text-dark">
                        <i class="far fa-comment mr-3"></i>
                        <p> {{ follow.comments }} </p>
                    </div>
                    <div class="flex items-center text-sm text-dark">
                        <i class="fas fa-retweet mr-3"></i>
                        <p> {{ follow.retweets }} </p>
                    </div>
                    <div class="flex items-center text-sm text-dark">
                        <i class="fas fa-heart mr-3"></i>
                        <p> {{ follow.like }} </p>
                    </div>
                    <div class="flex items-center text-sm text-dark">
                        <i class="fas fa-share-square mr-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Home',
    data() {
        return {
            user: {},
            tweet: {text: ''},
            following: [
                {
                    src: 'https://randomuser.me/api/portraits/women/52.jpg',
                    name: 'Giza Lamo',
                    handle: '@giza',
                    time: '1.2 hr',
                    tweet: 'The very essence of TailWindCSS??',
                    comments: '500',
                    retweets: '250',
                    like: '52,003'
                },
                {
                    src: 'https://randomuser.me/api/portraits/women/62.jpg',
                    name: 'Doug mama',
                    handle: '@mama',
                    time: '25 min',
                    tweet: 'Should I use Flutter now?',
                    comments: '1000',
                    retweets: '500',
                    like: '70,003'
                }
            ],
        }
    },
    methods: {
        addTweet() {
            let temp = {
                text: this.tweet.text
            };
            this.following.push(temp)
            this.tweet = {
                text: ""
            }
        },
        handleGetUserObject() {
            this.user = this.$localStorage.get('user');
        }
    },
    mounted() {
        this.handleGetUserObject();
    }
}
</script>
