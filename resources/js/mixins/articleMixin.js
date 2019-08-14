import { mapGetters }   from 'vuex'
export default {
    data() {
        return {
            articleModal: {
                id:         null,
                visible:    false,
                title:      'Nouvel article',
                name:       '',
                content:    '',
                albums:     [],
                menus:       [],
            },
            editorOption: {
                // some quill options
            },
            articleRules: {
                required: ['name', 'content']
            }
        }
    },
    computed: {
        ...mapGetters({ userId: 'user/getUserId', isAdmin: 'user/isAdmin' }),
    },
    methods: {
        sendArticle() {
            const _self = this
            if (_self.articleModal.id === null) {
                _self.createArticle()
            } else {
                _self.updateArticle()
            }
        },
        newArticle() {
            const _self = this
            this.articleModal.visible = true
        },
        createArticle() {
            const _self = this
            _self.$http.post('api/article', 
                _self.formatData()
            ).then(
                (response) => {
                    _self.articleModal.visible = false
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
        },
        editArticle(id) {
            const _self = this
            _self.$http.get(
                'api/article/' + id + '/edit'
            ).then( response => {
                _self.articleModal.name = response.data.object.name
                _self.articleModal.menus = response.data.object.categories
                _self.articleModal.content = response.data.object.content
                _self.articleModal.albums = response.data.object.albums
                _self.articleModal.visible = true
                _self.articleModal.id = id
            }).catch( error => {
                _self.$store.dispatch("showError", {
                    response:       error.response,
                    formElements:   _self.formErrors,
                    vue:            _self
                })
            })
        },
        updateArticle() {
            const _self = this
            _self.$http.patch('api/article/' + _self.articleModal.id, 
                _self.formatData()
            ).then(
                () => {
                    _self.articleModal.visible = false
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
            )
        },
        deleteArticle(id) {
            const _self = this
            this.$Confirm(
                'Êtes vous sûr de vouloir supprimer cet article ?', 
                'Suppression'
            ).then( () => {
                _self.$http.delete(
                    'api/article/' + id
                ).then(
                    () => {
                        this.$Message.success('Article supprimé');
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
        },
        getArticles() {
            const _self = this
            _self.$http.get('api/article').then(
                (response) => {
                    _self.articles = _self.reverseObject(response.data.articles)
                    _self.getAlbums()
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
        onEditorChange({ quill, html, text }) {
            this.articleModal.content = html
        },
        formatData() {
            const _self = this
            let menus = [],
                albums = []
            _self.articleModal.menus.forEach( (menu) => {
                menus.push(menu.id)
            })
            _self.articleModal.albums.forEach( (album) => {
                albums.push(album.id)
            })
            return {
                'name':         _self.articleModal.name,
                'categories':   menus,
                'content':      _self.articleModal.content,
                'user_id':      _self.userId,
                'albums':       albums
            }
        }
    }
}