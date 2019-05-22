<template>
    <div class="flex-center position-ref full-height">
        <div class="container">
            <div class="row">
                <main-report-component @submitClick="submitClick"></main-report-component>
                <div class="col-md-9" id="table">
                    <div class="col"><h3>{{report}}</h3></div>
                    <report-component @sendDate="sendDate"></report-component>
                    <div class="data-table" v-if="empty">
                        <div class="main-table">
                            <table class="ui celled table">
                                <thead>
                                <tr>
                                    <th class="table-head">#</th>
                                    <th v-for="column in columns" :key="column"
                                        class="table-head">
                                        {{ column | columnHead }}
                                        <span v-if="column === sortedColumn">
                            <i v-if="order === 'asc' " class="fas fa-arrow-up"></i>
                            <i v-else class="fas fa-arrow-down"></i>
            </span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="" v-if="tableData.length === 0">
                                    <td class="lead text-center" :colspan="columns.length + 1">No data found.</td>
                                </tr>
                                <tr v-for="(data, key1) in tableData" :key="data.id" class="m-datatable__row" v-else>
                                    <td>{{ serialNumber(key1) }}</td>
                                    <td v-for="(value, key) in data">{{ value }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <nav v-if="pagination && tableData.length > 0">
                            <ul class="pagination">
                                <li class="page-item" :class="{'disabled' : currentPage === 1}">
                                    <a class="page-link" href="#"
                                       @click.prevent="changePage(currentPage - 1)">Previous</a>
                                </li>
                                <li v-for="page in pagesNumber" class="page-item"
                                    :class="{'active': page == pagination.meta.current_page}">
                                    <a href="javascript:void(0)" @click.prevent="changePage(page)" class="page-link">{{
                                        page
                                        }}</a>
                                </li>
                                <li class="page-item" :class="{'disabled': currentPage === pagination.meta.last_page }">
                                    <a class="page-link" href="#" @click.prevent="changePage(currentPage + 1)">Next</a>
                                </li>
                                <span style="margin-top: 8px;"> &nbsp; <i>Displaying {{ pagination.report.length }} of {{ pagination.meta.total }} entries.</i></span>
                            </ul>
                        </nav>
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
                empty:        false,
                columns:      [],
                tableData:    [],
                report:       "",
                url:          '',
                pagination:   {
                    meta: {to: 1, from: 1}
                },
                offset:       4,
                currentPage:  2,
                perPage:      5,
                sortedColumn: '',
                order:        'asc',
                type:         '',
                report_id:    '',
                date_end:     '',
                date_start:   '',

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
            sendDate: function (dates) {

                this.date_start = dates[0]
                this.date_end   = dates[1]
                this.fetchData()
            },
            fetchData() {
                let dataFetchUrl = `${this.url}?page=${this.currentPage}&date_start=${this.date_start}&date_end=${this.date_end}&type=${this.type}&id=${this.report_id}`;

                axios.get(dataFetchUrl)
                    .then(({data}) => {
                        this.pagination = data
                        this.tableData  = data.report
                        this.columns    = data.keys

                        if (!this.columns.isEmpty) {
                            this.empty = true;
                        }
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
