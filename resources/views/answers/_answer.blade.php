<answer :answer="{{ $answer }}" inline-template>
    <div class="media post">
        @include ("shared._vote", [
            'model' => $answer,
        ])
        <div class="media-body">
            <form v-if="editing">
                <div class="form-group">
                    <textarea rows="10" v-model="body" class="form-control"></textarea>
                </div>
                <button type="button" @click="update" :disabled="isInvalid" class="btn btn-primary">Update</button>
                <button type="button" @click="cancel" class="btn btn-outline-secondary">Cancel</button>
            </form>
            <div v-else>
                <div v-html="bodyHtml"></div>
                <div class="row">
                    <div class="col-4">
                        <div class="ml-auto">
                            @can ('update', $answer)
                                {{--<a href="{{ route('questions.answers.edit', [$question->id, $answer->id]) }}" class="btn btn-sm btn-outline-info">
                                    Edit
                                </a>--}}
                                <a @click.prevent="edit" class="btn btn-sm btn-outline-info">Edit</a>
                            @endcan

                            @can ('delete', $answer)
                                <form action="{{ route("questions.answers.destroy", [$question->id, $answer->id]) }}" method="post" class="form-delete">
                                    @method ("DELETE")
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                        Delete
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                    <div class="col-4"></div>
                    <div class="col-4">
                        <user-info :model="{{ $answer }}" label="Answered"></user-info>
                    </div>
                </div>
            </div>
        </div>
    </div>
</answer>
