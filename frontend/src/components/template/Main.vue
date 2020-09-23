<template>
    <div class="main contentcontainer-fluid">
    <router-view></router-view>
    </div>
</template>

<script>

export default {
   
}
</script>

<style>
    .main {
        grid-area: main;
        background-color: #fff;
        padding: 20px;
        overflow:auto;
    }
</style>