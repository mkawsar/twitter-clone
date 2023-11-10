<template>
    <div id="app">
        <notifications transition-name="notification-list" transition-mode="out-in">

        </notifications>
        <router-view></router-view>
    </div>
</template>

<script>
import 'vue-notifyjs/themes/default.css';
export default {
    name: 'App'
}
</script>
