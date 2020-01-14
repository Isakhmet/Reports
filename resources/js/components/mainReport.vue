<template>
    <div class="main-report">

        <main-report-component  :category="getCategoryIsActive"
                                @subCategoryClick="subCategoryClick"
                                @showSubCategory="showSubCategory"
        ></main-report-component>
       <div ref="table">
           <h3>{{CDateFormShow.name}}</h3>
           <report-component v-if="CDateFormShow" @selectedDateReporting="selectedDateReporting" ></report-component>
           <div v-if="reports === 'no-data'">
               <h3>нет данных</h3>
           </div>

           <report-table v-else-if="reports" :reports="reports" :tableWidth="$refs.table.clientWidth" :formName="formName" />

       </div>
        <report-loading v-if="loading" @canceling="canceling" />

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
            loading: false,
            category: [ ],
            CDateFormShow: false,
            sendToApiForm: {
                page: 1,
                per_page: 15,
            },
            reports: null
        }),
        computed: {
            getCategoryIsActive(){
                return this.category.filter(item => item.is_active).map(item => {
                    item.get_reports.filter(sub => sub.is_active)
                    return item
                })
            },
            formName(){
                let name = this.CDateFormShow.name.replace(/ /g,"_")+ `_с_${this.sendToApiForm.date_start}_по_${this.sendToApiForm.date_end}`
                return {
                    xls: name + '.xls',
                    csv: name + '.csv',
                    xlsx: name + '.xlsx',
                }
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
                this.reports = false
                this.CDateFormShow = code
                this.sendToApiForm.id = code.code

            },
            selectedDateReporting(data){
                this.sendToApiForm.date_start = data['date_start']
                this.sendToApiForm.date_end = data['date_end']
                this.getReporting()
            },
            async getReporting(){
                this.loading = true
                this.reports = await axios.post(`${requests.getReport}`, this.sendToApiForm, {cancelToken: new CancelToken(function executor(c) { cancel = c })})
                    .then(res => {
                        console.log('res.data',res.data)
                        if(res.data.length == 0) {
                            return 'no-data'
                        }
                        return res.data
                    })
                    .catch( (thrown) => {
                    return false
                })
                this.loading = false
            },

        },
        async created() {
            let http = await axios.post(`${requests.getCategory}`)
            console.log('hello',http.data)
            http.data.map(item => {
                item.showSub = false
            })
            let filterData = http.data.filter(item => item.is_active).map(item => {
                // console.log(item.get_reports)
                item.get_reports = item['get_reports'].filter(sub => sub.is_active)
                return item
            })
            console.log('filter',filterData)
            this.sendToApiForm.type = filterData[0].code
            filterData[0].showSub = true

            this.category = filterData
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