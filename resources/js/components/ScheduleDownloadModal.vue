<template>
<div class="modal fade" id="scheduleDownload" tabindex="-1" role="dialog" aria-labelledby="scheduleDownload" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Скачать расписание</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                <form method="POST" :action="getScheduleDownloadResource()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Имя файла</label>
                            <input placeholder="Расписание" v-model="fileName" type="text" name="file_name" class="form-control">
                        </div>
                        <input type="hidden" name="filter" :value="filterQuery ? JSON.stringify(filterQuery) : undefined">
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-success">Скачать расписание</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
</template>

<script>
export default {
    name: 'schedule-download-modal',
    methods: {
        getScheduleDownloadResource() {
            return process.env.MIX_API_PATH + 'schedules/download'
        }
    },
    props: {
        filterQuery: {
            type: Object,
            default: () => {}
        }
    },
    data() {
        return {
            fileName: ''
        }
    }
}
</script>
