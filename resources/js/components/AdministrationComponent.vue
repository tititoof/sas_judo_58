<template>
    <div style="background: rgb(255, 255, 255); padding: 24px; min-height: 380px;">
        <h2>Administration</h2>
        <template v-if="isRegistred">
            <Row :space="9">
                <Cell width="24">
                    <div class="h-panel">
                        <div class="h-panel-bar">
                            <span class="h-panel-title">Articles</span>
                            <span class="h-panel-right"><a @click="newArticle">Ajouter</a></span>
                        </div>
                        <div class="h-panel-body scrollable-content">
                            <p v-for="article in articles" :key="article.id">
                                <ButtonGroup size="s">
                                    <Button color="primary" v-tooltip content="Edition" icon="h-icon-edit" @click="editArticle(article.id)"></Button>
                                    <Button color="red" v-tooltip content="Suppression" icon="h-icon-trash" @click="deleteArticle(article.id)"></Button>
                                </ButtonGroup>
                                {{ article.name }}
                            </p>
                        </div>
                    </div>
                </Cell>
            </Row>
            <Row :space="9">
                <Cell width="24">
                    <div class="h-panel">
                        <div class="h-panel-bar">
                            <span class="h-panel-title">Albums</span>
                            <span class="h-panel-right"><a @click="newAlbum">Ajouter</a></span>
                        </div>
                        <div class="h-panel-body scrollable-content">
                            <p v-for="album in albums" :key="album.id">
                                <ButtonGroup size="s">
                                    <Button color="primary" v-tooltip content="Edition" icon="h-icon-edit" @click="editAlbum(album.id)"></Button>
                                    <Button color="red" v-tooltip content="Suppression" icon="h-icon-trash" @click="deleteAlbum(album.id)"></Button>
                                </ButtonGroup>
                                {{ album.name }}
                            </p>
                        </div>
                    </div>
                </Cell>
            </Row>
            <Row :space="9">
                <Cell width="24">
                    <div class="h-panel">
                        <div class="h-panel-bar">
                            <span class="h-panel-title">Cours</span>
                            <span class="h-panel-right"><a @click="newCourse">Ajouter</a></span>
                        </div>
                        <div class="h-panel-body scrollable-content">
                            <p v-for="cours in courses" :key="cours.id">
                                <ButtonGroup size="s">
                                    <Button color="primary" v-tooltip content="Edition" icon="h-icon-edit" @click="editCourse(cours.id)"></Button>
                                    <Button color="red" v-tooltip content="Suppression" icon="h-icon-trash" @click="deleteCourse(cours.id)"></Button>
                                </ButtonGroup>
                                {{ cours.day }} : {{ cours.start_at }} - {{ cours.end_at }}
                            </p>
                        </div>
                    </div>
                </Cell>
            </Row>
        </template>
        <template v-else>
            <Form
                ref="form"
                :validOnChange="validOnChange"
                :showErrorTip="showErrorTip"
                :labelPosition="labelPosition"
                :labelWidth="130"
                :rules="validationRules"
                :model="formUser"
                >
                <FormItem label="Utilisateur" prop="name">
                    <template v-slot:label><i class="h-icon-user"></i> Utilisateur</template>
                    <input type="text" v-model="formUser.name">
                </FormItem>
                <FormItem label="Mot de passe" prop="password">
                    <template v-slot:label><i class="h-icon-complete"></i> Mot de passe</template>
                    <input type="password" v-model="formUser.password">
                </FormItem>
                <FormItem>
                    <Button color="primary" :loading="isLoading" @click="submit">Soumettre</Button>&nbsp;&nbsp;&nbsp;
                    <Button @click="reset">Annuler</Button>
                    <Button @click="signout">Déconnexion</Button>
                </FormItem>
            </Form>
        </template>
        <Modal v-model="articleModal.visible" v-bind="modalParams">
            <div slot="header"> {{ articleModal.title }}</div>
            <div style="auto">
                <Form
                    ref="articleForm"
                    :validOnChange="validOnChange"
                    :showErrorTip="showErrorTip"
                    :labelPosition="labelPosition"
                    :labelWidth="130"
                    :rules="articleRules"
                    :model="articleModal"
                    :top="0.2"
                    mode="block"
                    >
                    <FormItem label="Nom" prop="name">
                        <template v-slot:label> Nom</template>
                        <input type="text" v-model="articleModal.name">
                    </FormItem>
                    <FormItem label="Menus" prop="menu">
                        <template v-slot:label> Menus</template>
                        <Select v-model="articleModal.menus" :datas="menus" :multiple="true" type="object" keyName="id" titleName="name">
                        </Select>
                    </FormItem>
                    <FormItem label="Corps" prop="corps">
                        <template v-slot:label> Albums</template>
                        <Select v-model="articleModal.albums" :datas="albums" :multiple="true" type="object" keyName="id" titleName="name">
                        </Select>
                    </FormItem>
                    <FormItem label="Corps" prop="corps">
                        <template v-slot:label> Corps</template>
                        <quill-editor :content="articleModal.content"
                            :options="editorOption"
                            @change="onEditorChange($event)">
                        </quill-editor>
                    </FormItem>
                </Form>
            </div>
            <div slot="footer">
                <button class="h-btn" @click="close">Annuler</button>
                <button class="h-btn h-btn-primary" @click="sendArticle">Enregistrer</button>
            </div>
        </Modal>
        <Modal v-model="albumModal.visible" v-bind="modalParams">
            <div slot="header"> {{ albumModal.title }}</div>
            <div style="auto">
                <Form
                    ref="albumModal"
                    :validOnChange="validOnChange"
                    :showErrorTip="showErrorTip"
                    :labelPosition="labelPosition"
                    :labelWidth="130"
                    :rules="albumRules"
                    :model="albumModal"
                    :top="0.2"
                    mode="block"
                    >
                    <FormItem label="Nom" prop="name">
                        <template v-slot:label> Nom</template>
                        <input type="text" v-model="albumModal.name">
                    </FormItem>
                    <Row>
                        <vue-clip :options="albumModal.uploadOptions" :on-complete="addedAlbumFile">
                            <template slot="clip-uploader-action">
                                <div>
                                    <div class="dz-message">
                                        <h5> Click !! </h5>
                                    </div>
                                </div>
                            </template>
                            <template slot="clip-uploader-body" scope="props">
                                <div v-for="file in props.files" :key="file.name">
                                    <img v-bind:src="file.dataUrl" />
                                    {{ file.name }} {{ file.status }}
                                </div>
                            </template>
                        </vue-clip>
                    </Row>
                    <Row>
                        <ImagePreview :datas="albumModal.editPhotos" @click="openPreview" />
                    </Row>
                </Form>
            </div>
            <div slot="footer">
                <button class="h-btn" @click="closeAlbum">Annuler</button>
                <button class="h-btn h-btn-primary" @click="sendAlbum">Enregistrer</button>
            </div>
        </Modal>
        <Modal v-model="courseModal.visible" v-bind="modalParams">
            <div slot="header"> {{ courseModal.title }}</div>
            <div style="auto">
                <Form
                    ref="courseModal"
                    :validOnChange="validOnChange"
                    :showErrorTip="showErrorTip"
                    :labelPosition="labelPosition"
                    :labelWidth="130"
                    :rules="courseRules"
                    :model="courseModal"
                    :top="0.2"
                    mode="block"
                    >
                    <FormItem label="Nom" prop="name">
                        <template v-slot:label> Nom</template>
                        <input type="text" v-model="courseModal.name">
                    </FormItem>
                    <FormItem label="Saison" prop="season">
                        <template v-slot:label> Saison</template>
                        <Select v-model="courseModal.season" :datas="seasonOptions" keyName="value" titleName="label"></Select>
                    </FormItem>
                    <FormItem label="Jour" prop="day">
                        <template v-slot:label> Jour</template>
                        <Select v-model="courseModal.day" :datas="dayOptions" keyName="value" titleName="label"></Select>
                    </FormItem>
                    <FormItem label="Heure de début" prop="startAt">
                        <template v-slot:label> Heure de début</template>
                        <DatePicker v-model="courseModal.startAt" type="time"></DatePicker>
                    </FormItem>
                    <FormItem label="Heure de fin" prop="endAt">
                        <template v-slot:label> Heure de fin</template>
                        <DatePicker v-model="courseModal.endAt" type="time"></DatePicker>
                    </FormItem>
                    <FormItem label="Couleur" prop="color">
                        <template v-slot:label> Couleur</template>
                        <ColorPicker v-model="courseModal.color" :colors="colorOptions"></ColorPicker>
                    </FormItem>
                    <FormItem label="Enseignant" prop="color">
                        <template v-slot:label> Enseignant</template>
                        <Select v-model="courseModal.teacher" :datas="teacherOptions" keyName="value" titleName="label"></Select>
                    </FormItem>
                </Form>
            </div>
            <div slot="footer">
                <button class="h-btn" @click="closeCourse">Annuler</button>
                <button class="h-btn h-btn-primary" @click="sendCourse">Enregistrer</button>
            </div>
        </Modal>
        <Modal v-model="modalVisible" v-bind="modalParams">
            <div slot="header">Vue</div>
            <div style="auto">
                <div>This is a custom vue popup</div>
                <div><Select dict="simple" v-width="160"></Select></div>
            </div>
            <div slot="footer">
                <button class="h-btn" @click="close">Cancel</button>
                <button class="h-btn h-btn-primary" @click="confirm">Confirm</button>
            </div>
        </Modal>
    </div>
</template>

<script>
import ColorPicker from 'heyui/lib/components/color-picker'
import articleMixin from '../mixins/articleMixin'
import albumMixin from '../mixins/albumMixin'
import coursesMixin from '../mixins/coursesMixin'

import { mapGetters }   from 'vuex'
// require styles
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'
import { quillEditor } from 'vue-quill-editor'

export default {
    data() {
        return {
            isLoading: false,
            labelPosition: 'right',
            labels: {
                left: 'Label left aligned',
                right: 'Label right aligned'
            },
            formUser: {
                name: '',
                password: ''
            },
            validationRules: {
                required: ['name', 'password']
            },
            showErrorTip: true,
            validOnChange: true,
            articles:   [],
            albums:     [],
            menus:      [],
            modalVisible: false,
            modalParams: {
                closeOnMask: true,
                fullScreen: true,
                middle: false,
                hasMask: true,
                hasDivider: false
            },
        }
    },
    components: {
        quillEditor, ColorPicker
    },
    mixins: [ articleMixin, albumMixin, coursesMixin ],
    computed: {
        ...mapGetters({ isRegistred: 'user/isRegistred', isAdmin: 'user/isAdmin' }),
        reversedArticles() { 
            var NewObj = {}, keysArr = Object.keys(this.articles);
            for (var i = keysArr.length-1; i >= 0; i--) {
                NewObj[keysArr[i]] = this.articles[keysArr[i]];
            }
            return NewObj; 
        }
    },
    methods: {
        submit() {
            const _self = this
            this.isLoading = true;
            let validResult = this.$refs.form.valid()
            if (validResult.result) {
                _self.$store.dispatch('user/signin', { 
                    context: _self, email: _self.formUser.name, password: _self.formUser.password 
                }).then( (response) => {
                    console.log(response)
                    _self.$Message('Successful verification')
                    _self.getArticles()
                    this.isLoading = false
                }).catch ( error => {
                    this.isLoading = false
                })
            } else {
                this.isLoading = false
            }
        },
        reset() {
            this.$refs.form.resetValid()
        },
        signout() {
            const _self = this
            _self.$store.dispatch('user/signout', { context: _self })
        },
        getMenus() {
            const _self = this
            _self.$http.get('api/category').then(
                response => {
                    _self.menus = response.data.categories
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
        confirm() {
            this.articleModal.visible = false
        },
        close() {
            this.articleModal.visible = false
        },
        reverseObject(object) {
            var NewObj = {}, 
                keysArr = Object.keys(object),
                indexNewObj = 0;
            for (var i = keysArr.length - 1; i >= 0; i--) {
                NewObj[indexNewObj++] = object[keysArr[i]];
            }
            return NewObj;
        }
    },
    mounted() {
        if (this.isRegistred) {
            this.getArticles()
        }
    }
}
</script>

<style>
.scrollable-content {
    height: 180px;
    overflow: auto;
}
</style>
