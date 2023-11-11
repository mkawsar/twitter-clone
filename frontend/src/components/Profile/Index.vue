<template>
    <div>
        <div class="w-full bg-cover bg-no-repeat bg-center" style="height: 200px;" :style="{ 'background-image': 'url(' + user.banner + ')' }"></div>
        <div class="p-4">
            <div class="relative flex w-full">
                <!-- Avatar -->
                <div class="flex flex-1">
                    <div style="margin-top: -6rem;">
                        <div style="height:9rem; width:9rem;" class="md rounded-full relative avatar">
                            <img style="height:9rem; width:9rem;"
                                 class="md rounded-full relative border-4 border-gray-900"
                                 :src="user.image"
                                 alt="">
                            <div class="absolute"></div>
                        </div>
                    </div>
                </div>
                <!-- Follow Button -->
                <div class="flex flex-col text-right">
                    <router-link to="/profile/edit"
                        class="flex justify-center max-h-max whitespace-nowrap focus:outline-none focus:ring rounded-full max-w-max border bg-transparent border-blue-500 text-blue-500 hover:border-blue-800 items-center hover:shadow-lg font-bold py-2 px-4 mr-0 ml-auto">
                        Edit Profile
                    </router-link>
                </div>
            </div>

            <!-- Profile info -->
            <div class="space-y-1 justify-center w-full mt-3 ml-3">
                <!-- User basic-->
                <div>
                    <h2 class="text-xl leading-6 font-bold">{{ user.name }}</h2>
                </div>
                <!-- Description and others -->
                <div class="mt-3">
                    <div class="text-gray-600 flex">
                        <span class="flex mr-2">@{{ user.username }}</span>
                        <span class="flex mr-2"><svg viewBox="0 0 24 24" class="h-5 w-5 paint-icon"><g><path
                            d="M19.708 2H4.292C3.028 2 2 3.028 2 4.292v15.416C2 20.972 3.028 22 4.292 22h15.416C20.972 22 22 20.972 22 19.708V4.292C22 3.028 20.972 2 19.708 2zm.792 17.708c0 .437-.355.792-.792.792H4.292c-.437 0-.792-.355-.792-.792V6.418c0-.437.354-.79.79-.792h15.42c.436 0 .79.355.79.79V19.71z"></path><circle
                            cx="7.032" cy="8.75" r="1.285"></circle><circle cx="7.032" cy="13.156" r="1.285"></circle><circle
                            cx="16.968" cy="8.75" r="1.285"></circle><circle cx="16.968" cy="13.156" r="1.285"></circle><circle
                            cx="12" cy="8.75" r="1.285"></circle><circle cx="12" cy="13.156" r="1.285"></circle><circle
                            cx="7.032" cy="17.486" r="1.285"></circle><circle cx="12" cy="17.486"
                                                                              r="1.285"></circle></g></svg> <span
                            class="leading-5 ml-1">Joined {{ user.joined }}</span></span>
                    </div>
                </div>
                <div class="pt-3 flex justify-start items-start w-full divide-x divide-gray-800 divide-solid">
                    <div class="text-center pr-3"><span class="font-bold">{{ following }}</span><span
                        class="text-gray-600"> Following</span></div>
                    <div class="text-center px-3"><span class="font-bold">{{ follower }} </span><span
                        class="text-gray-600"> Followers</span></div>
                </div>
            </div>
        </div>
        <hr class="border-gray-800">

        <ul class="list-none">
            <li v-for="(item, index) in tweets" :key="index">
                <!--second tweet-->
                <article class="transition duration-350 ease-in-out">
                    <div class="flex flex-shrink-0 p-4 pb-0">
                        <a href="#" class="flex-shrink-0 group block">
                            <div class="flex items-center">
                                <div>
                                    <img class="inline-block h-10 w-10 rounded-full" :src="item.creator.image" alt="">
                                </div>
                                <div class="ml-3">
                                    <p class="text-base leading-6 font-medium">
                                        {{item.creator.name}}
                                        <span class="text-sm leading-5 font-medium transition ease-in-out duration-150">
                                            @{{item.creator.username}}  . {{item.ago}}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="pl-16">
                        <p class="text-base width-auto font-medium flex-shrink">
                            {{item.tweet}}
                        </p>

                        <div class="flex items-center py-4">

                            <div class="flex-1 flex items-center text-xs text-gray-400 hover:text-red-600 transition duration-350 ease-in-out">
                                <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2">
                                    <g>
                                        <path d="M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12zM7.354 4.225c-2.08 0-3.903 1.988-3.903 4.255 0 5.74 7.034 11.596 8.55 11.658 1.518-.062 8.55-5.917 8.55-11.658 0-2.267-1.823-4.255-3.903-4.255-2.528 0-3.94 2.936-3.952 2.965-.23.562-1.156.562-1.387 0-.014-.03-1.425-2.965-3.954-2.965z"></path>
                                    </g>
                                </svg>
                                {{item.like}}
                            </div>
                        </div>
                    </div>
                    <hr class="border-gray-800">
                </article>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: 'ProfileIndex',
    data() {
        return {
            user: {},
            follower: 0,
            following: 0,
            tweets: []
        }
    },
    methods: {
        handleGetProfileInfo() {
            axios.get(`${this.$env.BACKEND_API}/api/v1/auth/profile/info`)
                .then(res => {
                    let response = res.data;

                    this.user = response.user;
                    this.follower = response.follower;
                    this.following = response.following;
                    this.tweets = response.tweets;
                })
                .catch(err => {
                    console.log(err.response);
                })
        }
    },
    mounted() {
        this.handleGetProfileInfo();
    }
}
</script>