<template>
    <div class="loading-component">
        <div class="content">
            <h2>loading ...</h2>
            <button class="cancel-load" @click="canceling">Отменить загрузку</button>
        </div>
    </div>
</template>
<script>
    export default {
        methods:{
            canceling(){
                this.$emit('canceling')
            }
        }
    }
</script>
<style scoped lang="scss">
    .loading-component{
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(black, 0.5);
        .cancel-load{
            padding: 1rem;
            border: none;
            border-radius: 8px;
            background: #9f191f;
            font-size: 1rem;
            color: white;
            font-weight: bold;
        }
    }
</style>