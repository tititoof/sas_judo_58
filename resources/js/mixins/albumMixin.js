import { mapGetters }   from 'vuex'
export default {
    data() {
        return {
            albumModal: {
                id:         null,
                visible:    false,
                title:      'Nouvel album',
                name:       '',
                photos:     [],
                files:      [],
                editPhotos: [],
                uploadOptions:  {
                    url: '/api/picture',
                    paramName: 'file',
                    headers: {
                        'X-CSRF-TOKEN': document.getElementsByName('csrf-token')[0].getAttribute('content'),
                        'Authorization': 'Bearer ' + localStorage.getItem('id_token')
                    }
                }
            },
            albumRules: {
                required: ['name']
            }
        }
    },
    methods: {
        addedAlbumFile(file, status, xhr) {
            let fileIdOj = JSON.parse(xhr.response)
            this.albumModal.photos.push(fileIdOj.data)
        },
        sendAlbum() {
            const _self = this
            if (_self.albumModal.id === null) {
                _self.createAlbum()
            } else {
                _self.updateAlbum()
            }
        },
        closeAlbum() {
            const _self = this
            _self.albumModal.visible = false
        },
        createAlbum() {
            const _self = this
            _self.$http.post(
                    'api/album',
                    { 'name': _self.albumModal.name, 'user_id': _self.userId, 'pictures': _self.albumModal.photos, }
            ).then(
                response => {
                    _self.closeAlbum()
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
        newAlbum() {
            const _self = this
            _self.albumModal.visible = true
        },
        editAlbum(id) {
            const _self = this
            _self.$http.get('api/album/' + id + '/edit').then(
                (response) => {
                    const data  = response.data;
                    _self.albumModal.name  = data.object.name;
                    _self.albumModal.id    = id
                    _self.setPictures(data);
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
            _self.albumModal.visible = true
        },
        updateAlbum() {
            const _self = this
            _self.$http.patch(
                'api/album/' + _self.albumModal.id,
                { 'name': _self.albumModal.name, 'user_id': _self.userId, 'pictures': _self.albumModal.photos, }
            ).then(
                () => {
                    _self.closeAlbum()
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
        deleteAlbum(id) {
            const _self = this
            this.$Confirm(
                'Êtes vous sûr de vouloir supprimer cet album ?', 
                'Suppression'
            ).then( () => {
                _self.$http.delete(
                    'api/album/' + id
                ).then(
                    () => {
                        this.$Message.success('Album supprimé');
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
        setPictures(data) {
            const _self = this
            data.pictures.forEach( (picture) => {
                let tempo_picture = {
                    'id': picture.id,
                    thumbUrl: "/get/picture/" + picture.id + "/false",
                    url: "/get/picture/" + picture.id + "/false"
                }
                _self.albumModal.editPhotos.push(tempo_picture)
                _self.albumModal.photos.push(picture.id)
            })
        },
        openPreview(index = 0, data) {
            const _self = this
            console.log(data)
            _self.albumModal.editPhotos.$ImagePreview(_self.albumModal.editPhotos, index);
        },
        getAlbums() {
            const _self = this
            _self.$http.get('api/album').then(
                response => {
                    _self.albums = _self.reverseObject(response.data.albums)
                    _self.getMenus()
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
    }
}