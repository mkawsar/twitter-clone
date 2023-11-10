<template>
    <div>
        <div id="HelloWorld" class="flex container h-screen w-full">
            <div class="lg:w-1/5 border-r border-lighter px-2 lg:px-6 py-2 flex flex-col justify-between">
                <div>
                    <button class="h-12 w-12 hover:bg-lightblue text-3xl rounded-full text-blue">
                        <i class="fab fa-twitter"></i>
                    </button>
                    <div>
                        <button v-for="(tab,index) in tabs" :key="index" @click="id = tab.id"
                                :class="`focus:outline-none hover:text-blue flex items-center py-2 px-4 hover:bg-lightblue rounded-full mr-auto mb-3 ${ id === tab.id ? 'text-blue' : ''}`">
                            <i :class="`${ tab.icon } text-2xl mr-4 text-left`"></i>
                            <p class="text-lg font-semibold text-left hidden lg:block"> {{ tab.title }} </p>
                        </button>
                    </div>
<!--                    <button
                        class="text-white bg-blue rounded-full font-semibold focus:outline-none w-12 h-12 lg:h-auto lg:w-full p-3 hover:bg-darkblue">
                        <p class="hidden lg:block">Tweet</p>
                        <i class="fas fa-plus lg:hidden"></i>
                    </button>-->
                    <button
                        class="text-white bg-blue rounded-full font-semibold focus:outline-none w-12 h-12 lg:h-auto lg:w-full p-3 hover:bg-darkblue" style="background-color: rgb(29, 155, 240);">
                        <p class="hidden lg:block">Tweet</p>
                        <i class="fas fa-plus lg:hidden"></i>
                    </button>
                </div>
                <div class="lg:w-full relative">
                    <button @click="dropdown = !dropdown"
                            class="flex items-center w-full hover:bg-lightblue rounded-full p-2 focus:outline-none">
                        <img src="https://randomuser.me/api/portraits/men/11.jpg"
                             class="w-10 h-10 rounded-full border border-lighter"/>
                        <div class="hidden lg:block ml-4">
                            <p class="text-sm font-bold leading-tight"> Kriss Kawa </p>
                            <p class="text-sm leading-tight"> @kriss </p>
                        </div>
                        <i class="hidden lg:block fas fa-angle-down ml-auto text-lg"></i>
                    </button>
                    <div v-if="dropdown === true"
                         class="absolute bottom-0 left-0 w-64 rounded-lg shadow-md border-lightest bg-white mb-16">
                        <button @click="dropdown = false"
                                class="p-3 flex items-center w-full hover:bg-lightest p-2 focus:outline-none">
                            <img src="https://randomuser.me/api/portraits/men/11.jpg"
                                 class="w-10 h-10 rounded-full border border-lighter"/>
                            <div class="ml-4">
                                <p class="text-sm font-bold leading-tight"> Kriss Kawa </p>
                                <p class="text-sm leading-tight"> @kriss </p>
                            </div>
                            <i class="fas fa-check ml-auto test-blue"></i>
                        </button>
                        <button @click="dropdown = false"
                                class="w-full text-left hover:bg-lightest border-t border-lighter p-3 test-sm focus:outline-none">
                            Log out @kriss
                        </button>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-1/2 h-full overflow-y-scroll">
                <div class="px-5 py-3 border-b border-lighter flex items-center justify-between">
                    <h1 class="text-xl font-bold">Home</h1>
                    <i class="far fa-star text-xl text-blue"></i>
                </div>

                <div class="px-5 py-3 border-b-8 border-lighter flex">
                    <div class="flex-none">
                        <img src="https://randomuser.me/api/portraits/men/11.jpg"
                             class="flex-none w-12 h-12 rounded-full border border-lighter"/>
                    </div>
                    <form v-on:submit.prevent="addTweet" class="w-full px-4 relative">
                        <textarea v-model="tweet.text" placeholder="What's up?"
                                  class="mt-3 pb-3 w-full focus:outline-none"/>
                        <div class="flex items-center">
                            <i class="text-lg text-blue mr-4 far fa-image"></i>
                            <i class="text-lg text-blue mr-4 fas fa-film"></i>
                            <i class="text-lg text-blue mr-4 far fa-chart-bar"></i>
                            <i class="text-lg text-blue mr-4 far fa-smile"></i>
                        </div>
                        <button class="h-10 px-4 bg-blue-300 hover:bg-blue-700 text-white font-bold rounded-full absolute bottom-0 right-0" style="background-color: rgb(29, 155, 240);">
                            POST
                        </button>
                    </form>
                </div>

                <div class="flex flex-col-reverse">
                    <div v-for="(tweet, index) in tweetList" :key="index"
                         class="w-full p-4 border-b hover:bg-lighter flex">
                        <div class="flex-none mr-4">
                            <img src="https://randomuser.me/api/portraits/men/11.jpg"
                                 class="h-12 w-12 rounded-full flex-none"/>
                        </div>
                        <div class="w-full">
                            <div class="flex items-center w-full">
                                <p class="font-semibold"> Kriss Kawa </p>
                                <p class="text-sm text-dark ml-2"> @kriss </p>
                                <p class="text-sm text-dark ml-2"> 2 sec </p>
                                <i class="fas fa-angle-down text-dark ml-auto"></i>
                            </div>
                            <p class="py-2">
                                {{ tweet.text }}
                            </p>
                            <div class="flex items-center justify-between w-full">
                                <div class="flex items-center text-sm text-dark">
                                    <i class="far fa-comment mr-3"></i>
                                    <p> 1 </p>
                                </div>
                                <div class="flex items-center text-sm text-dark">
                                    <i class="fas fa-retweet mr-3"></i>
                                    <p> 0 </p>
                                </div>
                                <div class="flex items-center text-sm text-dark">
                                    <i class="fas fa-heart mr-3"></i>
                                    <p> 2 </p>
                                </div>
                                <div class="flex items-center text-sm text-dark">
                                    <i class="fas fa-share-square mr-3"></i>
                                </div>
                            </div>
                        </div>
                    </div>
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
            <!-- Trending Section-->
            <div class="md:block hidden w-1/3 h-full border-l border-lighter py-2 px-6 overflow-y-scroll relative">
                <input class="pl-12 rounded-full w-full p-2 bg-lighter text-sm mb-4" placeholder="Search Twitter"/>
                <i class="fas fa-search absolute left-0 top-0 mt-5 ml-12 text-sm text-light"></i>

                <div class="w-full rounded-lg bg-lightest" style="background-color: rgb(247, 249, 249);">
                    <div class="flex items-center justify-between p-3">
                        <p class="text-lg font-bold">Trends for You</p>
                        <i class="fas fa-cog text-lg text-blue"></i>
                    </div>
                    <button v-for="(trend,index) in trending" :key="index"
                            class="w-full flex justify-between hover:bg-lighter p-3 border-t border-lighter">
                        <div>
                            <p class="text-xs text-left leading-tight text-dark"> {{ trend.top }} </p>
                            <p class="font-semibold text-sm text-left leading-tight"> {{ trend.title }} </p>
                            <p class="text-left text-sm leading-tight text-dark"> {{ trend.bottom }} </p>
                        </div>
                        <i class="fas fa-angle-down text-lg text-dark"></i>
                    </button>
                    <button class="p-3 w-full hover:bg-lighter text-left text-blue border-t border-lighter">
                        Show More
                    </button>
                </div>

                <div class="w-full rounded-lg bg-lightest my-4" style="background-color: rgb(247, 249, 249);">
                    <div class=" p-3">
                        <p class="text-lg font-bold">Who to Follow</p>
                    </div>
                    <button v-for="(user,index) in follow" :key="index"
                            class="w-full flex hover:bg-lighter p-3 border-t border-lighter">
                        <img :src="`${ user.src }`" class="w-12 h-12 rounded-full border border-lighter"/>
                        <div class="hidden lg:block ml-4">
                            <p class="text-sm font-bold leading-tight"> {{ user.name }} </p>
                            <p class="text-sm leading-tight"> {{ user.handle }} </p>
                        </div>
                        <button class="ml-auto text-sm text-blue py-1 px-4 rounded-full border-2 border-blue">
                            Follow
                        </button>
                    </button>
                    <button class="p-3 w-full hover:bg-lighter text-left text-blue border-t border-lighter">
                        Show More
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'HelloWorld',
    data() {
        return {
            msg: 'Welcome to Your Vue.js App',
            tabs: [
                {icon: 'fas fa-home', title: 'Home', id: 'home'},
                {icon: 'fas fa-hashtag', title: 'Explore', id: 'explore'},
                {icon: 'far fa-bell', title: 'Notifications', id: 'notifications'},
                {icon: 'far fa-envelope', title: 'Messages', id: 'messages'},
                {icon: 'far fa-bookmark', title: 'Bookmarks', id: 'bookmarks'},
                {icon: 'fas fa-clipboard-list', title: 'Lists', id: 'lists'},
                {icon: 'far fa-user', title: 'Profile', id: 'profile'},
                {icon: 'fas fa-ellipsis-h', title: 'More', id: 'more'}
            ],
            dropdown: false,
            trending: [
                {top: 'techies all around', title: 'Tech', bottom: 'The technology'},
                {top: 'Apps', title: 'Flutter', bottom: '100K Tweets'},
                {top: 'Animals', title: 'Shark larger than Great white', bottom: '115k tweets'},
                {top: 'The techies nation', title: '2m servers', bottom: '30k tweets'},
            ],
            follow: [
                {src: 'https://randomuser.me/api/portraits/men/79.jpg', name: 'Kriss Kovan', handle: '@kriss'},
                {src: 'https://randomuser.me/api/portraits/men/70.jpg', name: 'Danny D', handle: '@theD'},
                {src: 'https://randomuser.me/api/portraits/men/27.jpg', name: 'Hubert Aly', handle: '@alyway'}
            ],
            tweetList: [
                {text: 'Why am I a nerd!'}
            ],
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
                },
                {
                    src: 'https://randomuser.me/api/portraits/men/63.jpg',
                    name: 'Ezy Pzy',
                    handle: '@ezypzy',
                    time: '2.7 hr',
                    tweet: 'Get Ready for the tech revolution',
                    comments: '10,000',
                    retweets: '100,002',
                    like: '200,003'
                },
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
                },
                {
                    src: 'https://randomuser.me/api/portraits/men/63.jpg',
                    name: 'Ezy Pzy',
                    handle: '@ezypzy',
                    time: '2.7 hr',
                    tweet: 'Get Ready for the tech revolution',
                    comments: '10,000',
                    retweets: '100,002',
                    like: '200,003'
                },
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
                },
                {
                    src: 'https://randomuser.me/api/portraits/men/63.jpg',
                    name: 'Ezy Pzy',
                    handle: '@ezypzy',
                    time: '2.7 hr',
                    tweet: 'Get Ready for the tech revolution',
                    comments: '10,000',
                    retweets: '100,002',
                    like: '200,003'
                },
            ],
        }
    },
    methods: {
        addTweet() {
            let temp = {
                text: this.tweet.text
            };
            this.tweetList.push(temp)
            this.tweet = {
                text: ""
            }

        }
    }
}
</script>
