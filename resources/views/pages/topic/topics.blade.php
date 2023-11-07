@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h2><b>Topics</b></h2>

                <div class="widget-content widget-content-area br-6">
                    <div class="row">
                        <div class=col-lg-10>
                            <form class="form-inline" method="POST" id="search">
                                <div class="form-group">
                                    <input type="text" id="name" class="form-control" placeholder="Name">
                                    &nbsp;&nbsp;
                                    <input type="text" id="category" class="form-control" placeholder="Category">
                                    &nbsp;&nbsp;
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-2">
                            @unlessrole('viewer')
                                <a href="{{ route('topic.create') }}"> <button class="btn btn-primary"><b
                                            style="color:white">Create
                                            Topics</b></button> </a>
                            @endunlessrole
                            <div class="my-2"></div>
                            @unlessrole('viewer')
                                <button class="btn btn-primary btn-limit-topic"><b style="color:white">Change Limit
                                        Topic</b></button>
                            @endunlessrole
                            <div class="my-2"></div>
                            @unlessrole('viewer')
                                <a href="{{ route('topic.export') }}"> <button class="btn btn-primary"><b
                                            style="color:white">Export
                                            Topics</b></button> </a>
                            @endunlessrole
                            <button class="btn btn-primary my-2" data-toggle="modal"
                                data-target="#modalChangeCategory">Change
                                Category</button>
                        </div>
                    </div>


                    <div class="table-responsive mb-4 mt-4">
                        <table id="tableTopics" class="table table-hover" style="width:100%"
                            aria-describedby="topics-table-description">
                            <caption id="topics-table-description">List of topics</caption>
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Name</th>
                                    <th>Icon</th>
                                    <th>Cover</th>
                                    <th>Categories</th>
                                    <th>Created at</th>
                                    <th>Sort</th>
                                    <th class="no-content">Followers</th>
                                    <th>Total Followers</th>
                                    <th>Total Post</th>
                                    <th>Sign</th>
                                    <th class="no-content">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="modal fade" id="detailCategory" tabindex="1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('topic.update') }}" method="post" id="modal-category">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel">Change Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <div id="cardCategory" class="">
                                <input type="text" id="topicId" name="topic_id" hidden>
                                <div class="form-group">
                                    <label for="topicName">Topic</label>
                                    <input type="text" class="form-control" id="topicName" placeholder="topic"
                                        name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="categorySelect">Category</label>
                                    <select class="form-control" id="categorySelect" name="categories">
                                        <option value="">Select Category</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Or</label><br>
                                    <label for="topicCategory">New Category</label>
                                    <input type="text" class="form-control" id="categoryInput" placeholder="Category"
                                        name="category">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-submit-category">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTopicSort" tabindex="1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('topic.update') }}" method="post" id="formTopicSort">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel">Change Sort Topic</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <div id="cardCategory" class="">
                                <input type="text" id="topicId" name="topic_id" hidden>
                                <div class="form-group">
                                    <label for="topicSort">Sort</label>
                                    <input type="text" class="form-control" id="topicSort" placeholder="topic"
                                        name="sort" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-submit-category">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTopicLimit" tabindex="1" aria-labelledby="detailModalLabelLimit"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('topic.limit.create') }}" method="post" id="formTopicLimit">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabelLimit">Change Limit Topic</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Current limit</label>
                            <input type="text" class="form-control current-limit-topic" value="2" disabled>
                        </div>
                        <div class="">
                            <div id="cardCategory" class="">
                                <div class="form-group">
                                    <label for="topicSort">Limit Topic</label>
                                    <input type="number" class="form-control" id="limitTopic" placeholder="0"
                                        name="sort" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-submit-category">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalTopicSign" tabindex="1" aria-labelledby="detailModalLabelTopicSign"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('topic.category.sign') }}" method="post" id="formTopicLimit">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabelTopicSign">Add Topic to OB</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <p><b>Show Topic in Onboarding</b></p>
                        </div>
                        <div class="form-group">
                            <label for="">Topic ID</label>
                            <input type="text" class="form-control topic-id-sign" name="topic_id" readonly>
                        </div>
                        <div class="form-group">
                            <label for="topicSort">Topic Name</label>
                            <input type="text" class="form-control name-topic-sign" placeholder="" name="sort"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label for="topicSort">Category</label>
                            <input type="text" class="form-control category-topic-sign" placeholder=""
                                name="category" disabled>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-submit-category">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalTopicUnSign" tabindex="1" aria-labelledby="detailModalLabelTopicUnSign"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('topic.category.un-sign') }}" method="post" id="formTopicLimit">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabelTopicUnSign">Remove from OB</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <p><b> Topic is disappear in onboarding</b></p>
                        </div>
                        <div class="form-group">
                            <label for="">Topic ID</label>
                            <input type="text" class="form-control topic-id-sign" name="topic_id" readonly>
                        </div>
                        <div class="form-group">
                            <label for="topicSort">Topic Name</label>
                            <input type="text" class="form-control name-topic-sign" placeholder="" name="sort"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label for="topicSort">Category</label>
                            <input type="text" class="form-control category-topic-sign" placeholder=""
                                name="category" disabled>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-submit-category">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalSameTopic" tabindex="1" aria-labelledby="detailModalLabelLimit"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('topic.remove-duplicate') }}" method="post" id="formSameTopic">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabelLimit">Remove the same topic</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <div id="cardCategory" class="">
                                <div class="form-group">
                                    <label for="topicSort">Which one will be deleted?</label>
                                    <select class="form-control" name="option" id="" required>
                                        <option value="">Select Option</option>
                                        <option value="latest">The latest one</option>
                                        <option value="oldest">The oldest one</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div>
                            <p>"If you choose the latest one,
                                all the latest topics will be deleted,
                                leaving only the oldest
                                topic. On the other hand, if you choose the oldest one,
                                all the oldest topics will be
                                deleted, leaving only the newest topic."
                            </p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-submit-category"
                            onclick="confirm('Are You sure?')">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalChangeIcon" tabindex="1" aria-labelledby="detailModalLabelLimit"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('topic.update-image') }}" method="POST" id="formChangeIcon"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <h5 class="title-modal-icon"></h5>
                        <div class="custom-file-container" data-upload-id="myFirstImage">
                            <label>Icon <a href="javascript:void(0)" class="custom-file-container__image-clear"
                                    title="Clear Image">x</a></label>
                            <label class="custom-file-container__custom-file">
                                <input id=file type="file"
                                    class="custom-file-container__custom-file__custom-file-input" accept="image/x-png"
                                    name="file">
                                <input type="hidden" name="MAX_FILE_SIZE" value="1024" />
                                <span class="custom-file-container__custom-file__custom-file-control"></span>
                            </label>
                            <div class="custom-file-container__image-preview"></div>
                        </div>
                        <input type="text" class="type-upload" name="type" hidden>
                        <input type="text" class="topic-id" name="id" hidden>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-submit-category"
                            onclick="confirm('Are You sure?')">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalChangeCategory" tabindex="1" aria-labelledby="detailModalLabelLimit"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Change or Delete Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="oldCategory">Old Category</label>
                        <input type="email" class="form-control" id="oldCategory" name="category"
                            placeholder="Enter Category" aria-describedby="emailHelp" required>
                    </div>
                    <div class="form-group">
                        <label for="newCategory">New Category</label>
                        <input type="email" class="form-control" id="newCategory" name="category"
                            placeholder="Enter Category" aria-describedby="emailHelp" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-change-category">Change</button>
                    <button type="button" class="btn btn-danger btn-delete-category">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection
