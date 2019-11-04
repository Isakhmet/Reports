<template>
    <div class="main-report">

        <main-report-component  :category="getCategoryIsActive"
                                @subCategoryClick="subCategoryClick"
                                @showSubCategory="showSubCategory"
        ></main-report-component>
       <div ref="table">
           <h3>{{CDateFormShow.name}}</h3>
           <report-component v-if="CDateFormShow" @selectedDateReporting="selectedDateReporting" ></report-component>
           <button @click="canceling">cancel</button>
           <report-table v-if="reports" :reports="reports" :tableWidth="$refs.table.clientWidth" />


       </div>
    </div>
</template>
<script>
    import axios from 'axios'
    let CancelToken = axios.CancelToken;
    let cancel;
    const requests = {
        getCategory: "/api/reports/getCategory",
        getReport: "/api/reports/getReports"
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
            },
            reports: null
        }),
        computed: {
            getCategoryIsActive(){
                return this.category.filter(item => item.is_active)
            }
        },
        methods: {
            canceling(){
                cancel()


            },
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
                this.reports = await axios.post(`${requests.getReport}`, this.sendToApiForm, {cancelToken: new CancelToken(function executor(c) { cancel = c })})
                    .then(res => {
                        console.log(res.data)
                        if(res.data.length == 0) {return false}
                        return res.data
                    })
                    .catch( (thrown) => {
                    return false
                })
            },

        },
        async created() {
            let http = await axios.post(`${requests.getCategory}`)
            console.log('hello',http.data)
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