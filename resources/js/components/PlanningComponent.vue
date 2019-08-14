<template>
    <div style="background: rgb(255, 255, 255); padding: 24px; min-height: 1000px;">
        <h2>Planning des cours</h2>
        <scheduler
            :time-ground='["15:00", "16:00", "17:00", "18:00", "19:00", "20:00", "21:00", "22:00" ]'
            :week-ground="['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche']"
            :task-detail="listCourses">
        </scheduler>
    </div>
</template>

<script>
import moment from 'moment'
import scheduler    from './SheduleComponent';
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
                        _self.courses     = data.objects;
                        _self.listCourses = data.scheduler;
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
            scheduler
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