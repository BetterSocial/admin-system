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
                            <div class="mt-2"></div>
                            @unlessrole('viewer')
                                <button class="btn btn-primary btn-limit-topic"><b style="color:white">Change Limit
                                        Topic</b></button>
                            @endunlessrole
                            <div class="mt-2"></div>
                            @unlessrole('viewer')
                                <a href="{{ route('topic.export') }}"> <button class="btn btn-primary"><b
                                            style="color:white">Export
                                            Topics</b></button> </a>
                            @endunlessrole
                        </div>
                    </div>


                    <div class="table-responsive mb-4 mt-4">
                        <table id="tableTopics" class="table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Name</th>
                                    <th>Icon</th>
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
                        <h5 class="modal-title" id="detailModalLabelTopicSign">Sign Topic</h5>
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
                        <h5 class="modal-title" id="detailModalLabelTopicUnSign">Un-Sign Topic</h5>
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
@endsection
