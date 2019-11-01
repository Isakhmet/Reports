<template>

    <div class="ui vertical menu">
        <div class="item" v-for="item in category" :key="item.code">
            <h2 class="menu-category__name" @click="showSubCateogry(item.code)">{{item.name}}</h2>
            <div class="" v-if="item.showSub">
               <p class="menu-subcategory__name" v-for="sub in item.subcategory" :key="sub.code">{{sub.name}}</p>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        props: {
            category: {
                type: Array
            }
        },

        filters: {
            descSort:   function (value) {
                return value.slice().reverse();
            },
            capitalize: function (str) {
                return str.charAt(10).toUpperCase() + str.slice(1)
            }
        },
        methods: {
            showSubCateogry(code){
                this.$emit('showSubCategory', code)

            }
        }
    }
</script>

<style lang="scss" scoped>
    .menu{
        height: max-content;
    }
    .menu-category__name{
        &:hover{
            cursor: pointer;
        }
    }
    .menu-subcategory__name{
        color: gray;
        &:hover{
            color: black;
            cursor: pointer;
         }
    }
</style>
