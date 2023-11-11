<template>
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
            <button v-for="(user, index) in follow" :key="index"
                    class="w-full flex hover:bg-lighter p-3 border-t border-lighter">
                <img :src="`${ user.profile }`" class="w-12 h-12 rounded-full border border-lighter"/>
                <div class="hidden lg:block ml-4">
                    <p class="text-sm font-bold">{{ user.name }}</p>
                    <p class="text-sm">@{{ user.username }}</p>
                </div>
                <button class="ml-auto text-sm text-blue py-1 px-4 rounded-full border-2 border-blue"
                        @click.prevent="handlePostFollowing(index)">
                    Follow
                </button>
            </button>
        </div>
    </div>
</template>
<script>
export default {
    name: 'Trend',
    data() {
        return {
            trending: [
                {top: 'techies all around', title: 'Tech', bottom: 'The technology'},
                {top: 'Apps', title: 'Flutter', bottom: '100K Tweets'},
                {top: 'Animals', title: 'Shark larger than Great white', bottom: '115k tweets'},
                {top: 'The techies nation', title: '2m servers', bottom: '30k tweets'},
            ],
            follow: [],
        }
    },
    methods: {
        handleGetAllPeople() {
            axios.get(`${this.$env.BACKEND_API}/api/v1/people/following/all/list`)
                .then(res => {
                    let response = res.data;
                    response.forEach(item => {
                        let obj = {};
                        obj.id = item.id;
                        obj.name = item.name;
                        obj.username = item.username;
                        obj.profile = item.file_id;
                        this.follow.push(obj);
                    })
                })
                .catch(err => {
                    console.log(err.response);
                })
        },
        handlePostFollowing(key) {
            axios.post(`${this.$env.BACKEND_API}/api/v1/people/following/${this.follow[key].id}/store`)
                .then(res => {
                    if (res.status === 201) {
                        this.follow = [];
                        this.handleGetAllPeople();
                        this.$notification.notify(this, 'Success', res.data.message);
                    }
                })
                .catch(err => {
                    this.$notification.error(this, 'Error', 'Something went wrong');
                })
        }
    },
    mounted() {
        this.handleGetAllPeople();
    }
}
</script>
