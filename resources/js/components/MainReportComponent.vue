<template>

    <div class="ui vertical menu">
        <div class="item" v-for="item in category" :key="item.code">
            <h3 class="menu-category__name" @click="showSubCateogry(item.code)">{{item.name}}</h3>
            <div class="" v-if="item.showSub">
               <p class="menu-subcategory__name"
                  v-for="sub in item.get_reports"
                  :key="sub.code"
                  @click="subClick(sub)"
                  :class="{active: sub.id == activeSub}"
               >{{sub.name}}</p>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data: () => ({
            activeSub: null
        }),
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
            },
            subClick(sub){
                this.activeSub = sub.id
                this.$emit('subCategoryClick', sub)
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
        &.active{
            color: black
        }
        &:hover{
            color: black;
            cursor: pointer;
         }
    }
</style>
