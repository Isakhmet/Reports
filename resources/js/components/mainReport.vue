<template>
    <div class="main-report">
        <main-report-component  :category="category" @showSubCategory="showSubCategory"></main-report-component>
       <div>
           <p>asdfsdf</p>
           <report-component />
       </div>
    </div>
</template>
<script>
    export default {
        data: () => ({
            category: [
                {
                    name: 'IVR',
                    code: 'ivr',
                    showSub: false,
                    subcategory: [
                        {
                            name: 'bla bla',
                            code: "code"
                        },
                        {
                            name: 'bla bla',
                            code: "code2"
                        }
                    ]
                },
                {
                    name: 'oracle',
                    code: 'ivr2',
                    showSub: false,
                    subcategory: [
                        {
                            name: 'bla bla',
                            code: "code"
                        },
                        {
                            name: 'bla bla',
                            code: "code2"
                        }
                    ]
                }
            ],
            CDateFormShow: false
        }),
        methods: {
            showSubCategory(code){
                this.category.map(item => {
                    if(item.code == code){
                        item.showSub = !item.showSub
                    }else{
                        item.showSub = false
                    }
                })
            }
        },
        created() {
            let http = this.$axios.post('/api/get/all')
            console.log(http)
        }
    }
</script>
<style scoped lang="scss">
.main-report{
    display: grid;
    grid-template-columns: auto 1fr;
    grid-gap: 1rem;
    padding: 0 1rem;
}
</style>