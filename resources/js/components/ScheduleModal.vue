<template>
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Добавление записи в расписание</h5>
                    <h5 class="modal-title" v-show="editmode">Редактирование информации о расписании</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                <form @submit.prevent="editmode ? updateSchedule() : createSchedule()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Группа</label>
                            <select name="type" v-model="form.group_id" id="type" class="form-control">
                                <option v-for="group in groups" :key="group.id" :value="group.id">
                                    {{group.name}}
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>День недели</label>
                            <select name="type" v-model="form.day_id" id="type" class="form-control">
                                <option v-for="day in days" :key="day.id" :value="day.id">
                                    {{day.name}}
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Время проведения</label>
                            <select name="type" v-model="form.pair_number_id" id="type" class="form-control">
                                <option v-for="number in pairNumbers" :key="number.id" :value="number.id">
                                    {{number.number}} пара - {{number.start}} - {{number.end}}
                                </option>
                            </select>
                        </div>

                        <span class="form-group">
                            <label>Прикрепить пары</label>
                            <span class="pair__selector">
                                <select v-model="selectedPair" name="type" id="type" class="form-control">
                                    <option v-for="pair in pairs" :key="pair.id" :value="pair.id">
                                        <pair-presenter :pair="pair" />
                                    </option>
                                </select>
                                <svg class="pair__button" @click.prevent="addPair" width="20" height="20" fill="green" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M432 256c0 17.69-14.33 32.01-32 32.01H256v144c0 17.69-14.33 31.99-32 31.99s-32-14.3-32-31.99v-144H48c-17.67 0-32-14.32-32-32.01s14.33-31.99 32-31.99H192v-144c0-17.69 14.33-32.01 32-32.01s32 14.32 32 32.01v144h144C417.7 224 432 238.3 432 256z"/></svg>
                            </span>

                            <ul class="list-group mt-2" v-if="form.pairs.length">
                                <li class="list-group-item pair__wrapper" v-for="pair, index in form.pairs" :key="pair.id">
                                    <pair-presenter :pair="pair" />
                                    <span class="pair__button" @click.prevent="deletePair(index)">
                                        <svg width="20" height="20" fill="red" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M400 288h-352c-17.69 0-32-14.32-32-32.01s14.31-31.99 32-31.99h352c17.69 0 32 14.3 32 31.99S417.7 288 400 288z"/></svg>
                                    </span>
                                </li>
                            </ul>

                        </span>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">Изменить</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">Создать</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
</template>

<script>
import {notificationMixin} from '../mixins/notificationMixin'
import PairPresenter from './layout/PairPresenter.vue'
export default {
    name: "group-modal",
    data() {
        return {
            days: [],
            pairNumbers: [],
            groups: [],
            pairs: [],
            selectedPair: 1,
        };
    },
    props: {
        editmode: {
            type: Boolean,
            default: () => false
        },
        form: {
            type: Object,
            default: () => { }
        },
        scheduleId: {
            type: Number,
        },
    },
    methods: {
        async updateSchedule() {
            await axios.put(process.env.MIX_DASHBOARD_PATH + `schedule/${this.scheduleId}`, this.form).then(() => {
                this.showSuccessMessage("Групппа была успешно изменена");
            }).catch(() => {
                this.showFailMessage("Не удалось изменить данные о группе");
            }).finally(() => {
                this.$emit("close_direction_modal");
            });
        },
        async createSchedule() {
            await axios.post(process.env.MIX_DASHBOARD_PATH + "schedule", this.form)
                .then(() => {
                this.showSuccessMessage("Запись была успешно добавлена!");
            }).catch(() => this.showFailMessage("Не удалось добавить запись в расписании"))
                .finally(() => this.$emit("close_direction_modal"));
        },
        async getGroups() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + "group/all")
                .then(({ data }) => this.groups = data.data)
                .catch(() => this.showFailMessage("Не удалось загрузить группы"));
        },
        async getDays() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + "day")
                .then(({ data }) => this.days = data.data)
                .catch(() => this.showFailMessage("Не удалось загрузить данные о времени обучения"));
        },
        async getPairNumbers() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + "pair_number")
                .then(({ data }) => this.pairNumbers = data.data)
                .catch(() => this.showFailMessage("Не удалось загрузить данные о расписании для пар"));
        },
        async getPairs() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + "pair/all")
                .then(({ data }) => this.pairs = data.data)
                .catch(() => this.showFailMessage("Не удалось загрузить данные о парах"));
        },
        findCurrentPair(id) {
            return this.pairs.filter(pair => pair.id === id)[0]
        },
        addPair() {
            this.$emit("add_pair", this.findCurrentPair(this.selectedPair));
        },
        deletePair(index) {
            this.$emit("delete_pair", index);
        }
    },
    async created() {
        await this.getGroups();
        await this.getDays();
        await this.getPairNumbers();
        await this.getPairs();
    },
    mixins: [notificationMixin],
    components: { PairPresenter }
}
</script>

<style lang="scss" scoped>
.pair {
    &__selector {
        display: flex;
        gap: 20px;
        align-items: center;
    }
    &__wrapper {
        background: lightgray;
    }
    &__button:hover {
        cursor: pointer;
    }
}

</style>
