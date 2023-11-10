<template>
    <div id="app">
        <notifications transition-name="notification-list" transition-mode="out-in">

        </notifications>
        <router-view></router-view>
    </div>
</template>

<script>
// import('sweetalert2/dist/sweetalert2.css');
// import('vue-notifyjs/themes/default.css');
export default {
    name: 'App'
}
</script>
