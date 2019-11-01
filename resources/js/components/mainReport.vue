<template>
    <div class="main-report">
        <main-report-component  :category="getCategoryIsActive"
                                @subCategoryClick="subCategoryClick"
                                @showSubCategory="showSubCategory"
        ></main-report-component>
       <div>
           <h3>{{CDateFormShow.name}}</h3>
           <report-component v-if="CDateFormShow" @selectedDateReporting="selectedDateReporting" ></report-component>
       </div>
    </div>
</template>
<script>
    import axios from 'axios'
    const requests = {
        getCategory: "/api/get/all",
        getReport: "/api/reports"
    }
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
            CDateFormShow: false,
            sendToApiForm: {
                page: 1,
                per_page: 15,
            }
        }),
        computed: {
            getCategoryIsActive(){
                return this.category.filter(item => item.is_active)
            }
        },
        methods: {
            showSubCategory(code){
                this.category.map(item => {
                    if(item.code == code){
                        this.sendToApiForm.type = code
                        item.showSub = !item['showSub']
                    }else{
                        item.showSub = false
                    }
                })
            },
            subCategoryClick(code){
                this.CDateFormShow = code
                this.sendToApiForm.id = code.code

            },
            selectedDateReporting(data){
                this.sendToApiForm.date_start = data['date_start']
                this.sendToApiForm.date_end = data['date_end']
                this.getReporting()
            },
            async getReporting(){
                console.log('form', this.sendToApiForm)
                let http = await axios.post(`${requests.getReport}`, this.sendToApiForm)
                console.log(http)
            }
        },
        async created() {
            let http = await axios.post(`${requests.getCategory}`)
            console.log(http.data)
            http.data.map(item => {
                item.showSub = false
            })
            this.category = http.data
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