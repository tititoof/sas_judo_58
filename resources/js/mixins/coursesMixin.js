import { mapGetters }   from 'vuex'
export default {
    data() {
        return {
            courses:        [],
            listCourses:    [],
            courseModal: {
                id:         null,
                visible:    false,
                title:      'Nouveau cours',
                startAt:    '',
                endAt:      '',
                name:       '',
                day:        '',
                color:      '',
                teacher:    '',
                season:     '',
            },
            courseRules: {
                required: ['name']
            },
            dayOptions:     [],
            seasonOptions:  [],
            teacherOptions: [],
            colorOptions:   ['#D14949', '#D1C649', '#7BD149', '#49BFD1', '#4959D1', '#B449D1', '#9575CD', '#D1C4E9']
        }
    },
    methods: {
        newCourse() {
            const _self = this;
            _self.$http.get('api/course/create').then(
                (response) => {
                    const data = response.data;
                    _self.teacherOptions = data.data.teachers
                    _self.seasonOptions  = data.data.seasons
                    _self.dayOptions     = data.data.days
                    _self.courseModal.visible = true
                }
            ).catch(
                error   => {
                    _self.$store.dispatch("showError", {
                        response:       error.response,
                        formElements:   _self.formErrors,
                        vue:            _self
                    })
                }
            )
        },
        editCourse(id) {
            const _self = this
            _self.$http.get(
                'api/course/' + id + '/edit'
            ).then(
                (response) => {
                    const data              = response.data
                    _self.teacherOptions    = data.data.teachers
                    _self.seasonOptions     = data.data.seasons
                    _self.dayOptions        = data.data.days
                    _self.courseModal.color = data.data.course.color
                    _self.courseModal.name  = data.data.course.name
                    _self.courseModal.season = data.data.course.season_id
                    _self.courseModal.teacher = data.data.course.teacher_id
                    _self.courseModal.day = data.data.course.day
                    _self.courseModal.startAt = data.data.course.start_at
                    _self.courseModal.endAt = data.data.course.end_at
                    _self.courseModal.id    = id
                    _self.courseModal.visible = true
                }
            ).catch(
                error   => {
                    _self.$store.dispatch("showError", {
                        response:       error.response,
                        formElements:   _self.formErrors,
                        vue:            _self
                    })
                }
            )
            console.log('edit course ' + id)
        },
        updateCourse() {
            const _self = this;
                _self.$http.patch('api/course/' + _self.courseModal.id, { 
                    'name':         _self.courseModal.name,                  
                    'day':          _self.courseModal.day,
                    'start_at':     _self.courseModal.startAt,           
                    'end_at':       _self.courseModal.endAt,
                    'teacher_id':   _self.courseModal.teacher, 
                    'season_id':    _self.courseModal.season,
                    'color':        _self.courseModal.color
                }).then(
                    () => {
                        _self.courseModal.visible = false
                        _self.getCourses()
                    }
                ).catch(
                    error   => {
                        _self.$store.dispatch("showError", {
                            response:       error.response,
                            formElements:   _self.formErrors,
                            vue:            _self
                        })
                    }
                )
        },
        deleteCourse(id) {
            const _self = this
            this.$Confirm(
                'Êtes vous sûr de vouloir supprimer ce cours ?', 
                'Suppression'
            ).then( () => {
                _self.$http.delete(
                    'api/course/' + id
                ).then(
                    () => {
                        this.$Message.success('Cours supprimé');
                        _self.getArticles()
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
            }).catch(() => {
                this.$Message.error('Annulation');
            });
            console.log('delete course ' + id)
        },
        getCourses() {
            const _self = this
            _self.$http.get('api/course').then(
                (response) => {
                    const data        = response.data
                    _self.courses     = data.objects
                    _self.listCourses = data.scheduler
                }
            ).catch(
                error   => {
                    _self.$store.dispatch("showError", {
                        response:       error.response,
                        formElements:   _self.formErrors,
                        vue:            _self
                    })
                }
            )
        },
        closeCourse() {
            this.courseModal.visible = false
        },
        createCourse() {
            const _self = this
            _self.$http.post('api/course', { 
                'name':         _self.courseModal.name,                  
                'day':          _self.courseModal.day,
                'start_at':     _self.courseModal.startAt,           
                'end_at':       _self.courseModal.endAt,
                'teacher_id':   _self.courseModal.teacher, 
                'season_id':    _self.courseModal.season,
                'color':        _self.courseModal.color
            }).then(
                () => {
                    _self.getCourses()
                    _self.courseModal.visible = false
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
        sendCourse() {
            const _self = this
            if (_self.courseModal.id === null) {
                _self.createCourse()
            } else {
                _self.updateCourse()
            }
        }
    }
}