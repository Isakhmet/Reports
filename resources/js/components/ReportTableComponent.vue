<template>
    <div class="flex-center position-ref full-height">
        <div class="container">
            <div class="row">
                <main-report-component @submitClick="submitClick"></main-report-component>
                <div class="col-md-9" id="table">
                    <div class="col report-title"><p>{{report}}</p></div>
                    <report-component :loading="loading" @sendDate="sendDate"></report-component>
                        <div v-if="loading" class="ui active inverted dimmer">
                            <div class="ui large text loader">Загрузка отчета...</div>
                        </div>
                    <div class="data-table" v-if="empty">
                        <div class="main-table">
                            <table class="ui single line table">
                                <thead>
                                <tr>
                                    <th class="table-head">#</th>
                                    <th v-for="column in columns" :key="column"
                                        class="table-head">
                                        {{ column | columnHead }}

                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="" v-if="tableData.length === 0">
                                    <td class="lead text-center" :colspan="columns.length + 1">No data
                                        found.{{tableData.length}}
                                    </td>
                                </tr>
                                <tr v-for="(data, key1) in tableData" :key="data.id" class="m-datatable__row" v-else>
                                    <td>{{ serialNumber(key1) }}</td>
                                    <td v-for="(value, key) in data" v-if="key !== 'amounts'">{{value}}</td>
                                    <td class="amounts" @click="openModal(value)" v-else>...
                                        <modal-new :months="amounts"></modal-new>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <nav v-if="pagination && tableData.length > 0">
                            <ul class="pagination">
                                <li class="page-item" :class="{'disabled' : currentPage === 1}">
                                    <a class="page-link" href="#"
                                       @click.prevent="changePage(currentPage - 1)">Предыдущая</a>
                                </li>
                                <li v-for="page in pagesNumber" class="page-item"
                                    :class="{'active': page == pagination.meta.current_page}">
                                    <a href="javascript:void(0)" @click.prevent="changePage(page)" class="page-link">{{
                                        page
                                        }}</a>
                                </li>
                                <li class="page-item" :class="{'disabled': currentPage === pagination.meta.last_page }">
                                    <a class="page-link" href="#" @click.prevent="changePage(currentPage + 1)">Следующая</a>
                                </li>
                                <span style="margin-top: 8px;"> &nbsp; <i>Показано {{ pagination.report.length }} из {{ pagination.meta.total }} записей.</i></span>
                            </ul>
                        </nav>
                        <export-excel
                            :data="json_data"
                            :fields="json_fields"
                            worksheet="My Worksheet"
                            :name="filename">
                            <button class="download">Скачать</button>
                        </export-excel>
                        <export-excel
                                :data   = "json_data"
                                :fields = "json_fields"
                                type    = "csv"
                                :name    = "filenameCSV">
                            <button class="download">Скачать CSV</button>
                        </export-excel>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/ecmascript-6">
    export default {
        props:    {
            fetchUrl: {type: String, required: true}
        },
        data() {
            return {
                json_fields:  {},
                json_data:    [],
                amounts:      Object,
                showModal:    false,
                empty:        false,
                columns:      [],
                tableData:    [],
                report:       "Выберите тип отчета",
                url:          '',
                pagination:   {
                    meta: {to: 1, from: 1}
                },
                offset:       4,
                currentPage:  1,
                perPage:      15,
                sortedColumn: '',
                order:        'asc',
                type:         '',
                report_id:    '',
                date_end:     '',
                date_start:   '',
                filename:     '',
                loading:    false

            }
        },
        watch:    {
            fetchUrl: {
                handler:   function (fetchUrl) {
                    this.url = fetchUrl
                },
                immediate: true
            }
        },
        mounted() {
            this.$on('report', 'mega');
        },
        computed: {
            /**
             * Get the pages number array for displaying in the pagination.
             * */
            pagesNumber() {
                if (!this.pagination.meta.to) {
                    return []
                }
                let from = this.pagination.meta.current_page - this.offset
                if (from < 1) {
                    from = 1
                }
                let to = from + (this.offset * 2)

                if (to >= this.pagination.meta.last_page) {
                    to = this.pagination.meta.last_page
                }
                let pagesArray = []
                for (let page = from; page <= to; page++) {
                    pagesArray.push(page)
                }

                return pagesArray
            },
            /**
             * Get the total data displayed in the current page.
             * */
            totalData() {
                return (this.pagination.meta.to - this.pagination.meta.from) + 1
            }
        },
        methods:  {
            openModal:   function (value) {
                console.log(value);
                this.amounts = value;
                this.$modal.push('example')
            },
            getAmmounts: function () {
                return this.amounts;
            },
            sendDate:   function  (dates) {

                this.date_start = dates[0]
                this.date_end   = dates[1]

                this.fetchData()
            },
            fetchData() {
                this.loading = true
                axios.post(this.url, {
                    page:       this.currentPage,
                    date_start: this.date_start,
                    date_end:   this.date_end,
                    type:       this.type,
                    id:         this.report_id

                })
                    .then(({data}) => {
                        console.log(data)
                        this.pagination = data
                        this.tableData  = data.report
                        this.columns    = data.keys

                        if (data.excel !== null) {
                            this.json_fields = data.excel.columns;
                            this.json_data   = data.excel.data;
                        }

                        var reportName = this.report.split(' ').join('-');
                        this.filename  = reportName + '-c-' + this.date_start + '-по-' + this.date_end + '.xls';
                        this.filenameCSV  = reportName + '-c-' + this.date_start + '-по-' + this.date_end + '.csv';
                        console.log(this.filename);
                        if (!this.columns.isEmpty) {
                            this.empty = true;
                        }
                        this.loading = false
                    }).catch(error => this.tableData = [])
            },
            /**
             * Get the serial number.
             * @param key
             * */
            serialNumber(key) {
                return (this.currentPage - 1) * this.perPage + 1 + key
            },
            /**
             * Change the page.
             * @param pageNumber
             */
            changePage(pageNumber) {

                this.currentPage = pageNumber
                this.fetchData()
                console.log(pageNumber)
            },
            /**
             * Sort the data by column.
             * */
            sortByColumn(column) {
                if (column === this.sortedColumn) {
                    this.order = (this.order === 'asc') ? 'desc' : 'asc'
                } else {
                    this.sortedColumn = column
                    this.order        = 'asc'
                }
                this.fetchData()
            },
            submitClick(data) {
                this.report    = data[0]
                this.type      = data[1]
                this.report_id = data[2]
            }
        },
        filters:  {
            columnHead(value) {
                return value.split('_').join(' ').toUpperCase()
            }
        },
        name:     'DataTable'
    }
</script>
