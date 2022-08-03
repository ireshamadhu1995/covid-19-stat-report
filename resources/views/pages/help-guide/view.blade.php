@extends('layouts.default')

@section('content')
<div id="helpGuideUpdate">
    <div class="row g-0">
        <div class="col-md-12 p-0">
            <div class="row g-0">
                <div class="col-md-6 p-0">
                    <div class="page-heading">
                        <h1>View - {{ $helpGuide->topic }}</h1>
                    </div>
                </div>
                <div class="col-md-6 p-0">
                    <div class="col-md-12">
                    <div class="col-md-12">
                            <div class="text-right">
                            <button class="btn btn-danger float-end" @click="remove('helpGuide',null)">Delete Help Guide</button>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <form onsubmit="return false">
                    @csrf
                    @method('put')
                    <div class="row">



                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="topic" class="form-label">Topic</label>
                                <input type="text" name="topic" class="form-control page-input" id="topic" disabled
                                    placeholder="Enter help guide topic" v-model="topic"
                                    value="{{ $helpGuide->topic }}">
                                <span class="text-danger" v-if="error_topic">@{{ error_topic }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="link" class="form-label">Link</label>
                                <input type="text" name="link" class="form-control page-input" id="link" disabled
                                    placeholder="Enter help guide link" v-model="link" value="{{ $helpGuide->link }}">
                                <span class="text-danger" v-if="error_link">@{{ error_link }}</span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" rows="6" id="description" class="form-control page-input"disabled
                                    v-model="description" placeholder="Enter description"
                                    value="{{ old('description') }}"></textarea>

                                <span class="text-danger" v-if="error_description">@{{ error_description }}</span>
                            </div>
                        </div>

                        <div class="col-sm-12 form-boxes-inner">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Upload Images</label>
                                <template v-for="(image, index) in imgData">
                                    <div class="edit-video-pre-wrap">
                                        <div class="h-100">
                                            <img :src="host+image.path" width="300" />
                                          
                                        </div>
                                    </div>
                                </template>

                            </div>
                        </div>

                  

                        <div class="col-md-12">
                            <div class="text-right">
                                <button class="btn btn-secondary" @click="cancel()">Close</button>
                               
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
        const csrf_token = "{{ csrf_token() }}";
        var helpGuideUpdate = new Vue({
            el: '#helpGuideUpdate',
            data() {
                return {
                    fileRecordsForUpload: [], // maintain an upload queue
                    fileRecords: [],
                    files: [],
                    topic: null,
                    id: null,
                    link: null,
                    description: null,
                    api_error_response: null,
                    errors: undefined,
                    error_topic: null,
                    error_description: null,
                    error_link: null,
                    helpGuide: @json($helpGuide),
                    imgData: @json($images),
                    host: 'http://127.0.0.1:8000/',
                };
            },
            watch: {
                api_error_response(new_api_error_response) {
                    this.errors = new_api_error_response.data.errors;
                    this.error_topic = this.isset(this.errors.topi) ? this.errors.topi[0] : '';
                    this.error_description = this.isset(this.errors.description) ? this.errors.description[0] : '';
                    this.error_link = this.isset(this.errors.link) ? this.errors.link[0] : '';
                    
                }
            },

            mounted() {
               
                this.id = this.helpGuide.id;
                this.topic = this.helpGuide.topic;
                this.description = this.helpGuide.description;
                this.link = this.helpGuide.link;


            },
            methods: {

                cancel(){
                    window.location.href = "{{ route('help-guide.index') }}";

                }

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
