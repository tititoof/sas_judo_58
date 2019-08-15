<template>
    <div style="background: rgb(255, 255, 255); padding: 24px; min-height: 1000px;">
        <h2>Planning des cours</h2>
        <show-at breakpoint="mediumAndBelow">
            <ul style="list-style-type: none;">
                <li v-for="(week, index) in ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche']" :key="index">
                    <h1>{{ week }}</h1>
                    <ul style="list-style-type: none;">
                        <template v-for="(day, indexCourse) in listCourses">
                            <template v-if="index == indexCourse">
                                <template v-for="(course, indexCourse) in day">
                                    <li v-bg-color="course.color" v-if="course.hasOwnProperty('dateStart')" :key="indexCourse">
                                        <p class="task-list-item-phone-p"> {{ course.dateStart }} - {{ course.dateEnd }}</p>
                                        <h5 class="task-list-item-phone-h"> {{ course.title }} </h5>    
                                    </li>
                                </template>
                            </template>
                        </template>
                    </ul>
                </li>
            </ul>
        </show-at>
        <show-at breakpoint="large">
            <scheduler
                :time-ground='["15:00", "16:00", "17:00", "18:00", "19:00", "20:00", "21:00", "22:00" ]'
                :week-ground="['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche']"
                :task-detail="listCourses">
            </scheduler>
        </show-at>
    </div>
</template>

<script>
import moment from 'moment'
import scheduler    from './SheduleComponent'
import {showAt, hideAt} from 'vue-breakpoints'
export default {
        data() {
            return {
                courses:      [],
                listCourses:  [],
                deleteId:     ''
            }
        },
        methods: {
            index() {
                const _self = this;
                _self.$http.get('api/visitor/courses').then(
                    (response) => {
                        const data          = response.data;
                        _self.courses       = data.objects;
                        _self.listCourses   = data.scheduler;
                    }
                ).catch(
                    error   => {
                        _self.$store.dispatch("showError", {
                            response:       error.response,
                            formElements:   _self.formErrors,
                            vue:            _self
                        })
                    }
                );
            },
            scrollTop() {
                window.scrollTo(0,0)
            }
        },
        components: {
            scheduler, hideAt, showAt
        },
        mounted() {
            this.$nextTick(function() {
                const _self = this;
                _self.index();
            });
        },
        watch: {
            '$route.params.menu'(newId, oldId) {
                this.index()
            }
        }
    }
</script>

<style>

</style>