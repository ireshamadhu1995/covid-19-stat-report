@extends('layouts.default')

@section('content')
    <div id="helpGuideCreate">
        <div class="row g-0">
            <div class="col-md-12 p-0">
                <div class="page-heading">
                    <h1>Create Help & Guide</h1>
                </div>

                <div class="mt-5">
                <form onsubmit="return false">
                       
                        <div class="row">

                          
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="topic" class="form-label">Topic</label>
                                    <input type="text" name="topic" class="form-control page-input" id="topic" v-model ="topic" placeholder="Enter topic" value="{{old('topic')}}">
                                    <span class="text-danger" v-if="error_topic">@{{ error_topic }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="link" class="form-label">Link</label>
                                    <input type="text" name="link" class="form-control page-input" id="link" v-model ="link" placeholder="Enter link" value="{{old('link')}}">
                                    <span class="text-danger" v-if="error_link">@{{ error_link }}</span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" rows="6" id="description" class="form-control page-input" v-model ="description" placeholder="Enter description" value="{{old('description')}}"></textarea>
                                   
                                    <span class="text-danger" v-if="error_description">@{{ error_description }}</span>
                                </div>
                            </div>
                      

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Upload Images</label>
                                    <template>
                                        <div>
                                            <vue-file-agent v-model="fileRecords" :theme="'grid'" :multiple="true"
                                                            :deletable="true" :meta="true" :accept="'image/*'"
                                                            :max-size="'10MB'"
                                                            :max-files="10" :help-text="'Choose images'" :error-text="{
                                            type: 'Invalid file type. Only images',
                                            size: 'Files should not exceed 10MB in size',
                                            }" @select="filesSelected($event)" @beforedelete="onBeforeDelete($event)"
                                                            @delete="fileDeleted($event)">
                                                >
                                            </vue-file-agent>
                                        </div>
                                    </template>
                                </div>
                            </div>

                           

                            <div class="col-md-12 mt-3">
                                <div class="text-right">
                                    <button class="btn btn-secondary" @click="cancel()">Cancel</button>
                                    <button class="btn btn-primary" @click="saveContent()">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <script type="module">
        Vue.component('vue-multiselect', window.VueMultiselect.default);
        Vue.component('vue-upload-multiple-image', window.VueUploadMultipleImage);
        Vue.component('vue-file-agent', window.VueFileAgent.default);
        const csrf_token = "{{csrf_token()}}";
        var helpGuideCreate = new Vue({
            el: '#helpGuideCreate',
            data() {
                return {
                    fileRecordsForUpload: [], // maintain an upload queue
                    fileRecords: [],
                    files: [],
                    topic: '',
                    link:'',
                    description: '',
                    api_error_response: null,
                    errors: undefined,
                    error_topic: null,
                    error_description: null,
                    error_link: null
                   
                };
            },
            watch: {
                api_error_response(new_api_error_response) {
                    this.errors = new_api_error_response.data.errors;
                    this.error_topic = this.isset(this.errors.topic) ? this.errors.topic[0] : '';
                    this.error_description = this.isset(this.errors.description) ? this.errors.description[0] : '';
                    this.error_link = this.isset(this.errors.link) ? this.errors.link[0] : '';
                    
                }
            },
            methods: {
                filesSelected(fileRecordsNewlySelected) {
                    var validFileRecords = fileRecordsNewlySelected.filter((fileRecord) => !fileRecord.error);
                    this.fileRecordsForUpload = this.fileRecordsForUpload.concat(validFileRecords);
                    let uploadedFiles = this.$refs.validFileRecords;
                },
                onBeforeDelete(fileRecord) {
                    var i = this.fileRecordsForUpload.indexOf(fileRecord);
                    if (i !== -1) {
                        this.fileRecordsForUpload.splice(i, 1);
                        var k = this.fileRecords.indexOf(fileRecord);
                        if (k !== -1) this.fileRecords.splice(k, 1);
                    }
                },
                fileDeleted(fileRecord) {
                    var i = this.fileRecordsForUpload.indexOf(fileRecord);
                    if (i !== -1) {
                        this.fileRecordsForUpload.splice(i, 1);
                    }
                },
                isset(variable) {
                    if (typeof variable === 'undefined' || variable === null) {
                        return false;
                    } else {
                        return true;
                    }
                },

                showDefaultAlertMessage(type, title, text) {
                Swal.fire({
                    title: title,
                    text: text,
                    icon: type,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#E20010'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{route('help-guide.index')}}";
                    } else {
                        // location.reload();
                    }
                })
                },
                cancel(){
                    window.location.href = "{{route('help-guide.index')}}";
                    this.topic = '';
                    this.link = '';
                    this.description = '';
                    this.fileRecords= [];
                    this.fileRecordsForUpload= [];
                    this.files= [];

                },
                saveContent(e) {
                 
                    this.error_topic = '';
                    this.error_description = '';
                    this.error_link = '';

                    const that = this;
                    const config = {
                        headers: {
                            'content-type': 'multipart/form-data'
                        }
                    }

                    let formData = new FormData();
                    formData.append("topic", this.topic);
                    formData.append("link", this.link);
                    formData.append("description", this.description);
                 
                  
                    for (let index = 0; index < this.fileRecords.length; index++) {
                        const element = this.fileRecords[index].file;
                        formData.append("images[]", element);
                    }

                    axios.post('{{ route('help-guide.store') }}', formData, config)
                        .then(response => {
                            if (response.status === 200) {
                                that.showDefaultAlertMessage('success', 'Success', response.data.message);
                            } 
                        }).catch(error => {
                            this.api_error_response = error.response;
                    });
                },
            },
        })
    </script>

<style>
        .file-upload-form,
        .image-preview {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            padding: 20px;
        }

        img.preview {
            width: 200px;
            background-color: white;
            border: 1px solid #DDD;
            padding: 5px;
        }

        .validations {
            font-size: 11px;
            color: rgb(255, 0, 0);
        }
</style>
@endsection
