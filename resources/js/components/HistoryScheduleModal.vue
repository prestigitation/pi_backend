<template>
<div class="modal fade" id="scheduleHistory" tabindex="-1" role="dialog" aria-labelledby="scheduleHistory" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Предыдущее расписание</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div v-if="$props.scheduleHistory">
                    <ul>
                        <a v-for="snapshot in $props.scheduleHistory.data" :key="snapshot.id" :href="snapshot.schedule_path">
                            <li>{{snapshot.name}}</li>
                        </a>
                    </ul>

                    <pagination
                        :data="$props.scheduleHistory"
                        @pagination-change-page="$emit('paginate_schedule_history')"
                    />
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import {notificationMixin} from '../mixins/notificationMixin'
export default {
    name: 'history-schedule-modal',
    mixins: [notificationMixin],
    props: {
        scheduleHistory: {
            type: Object,
            default: () => null
        }
    },
}
</script>

