<div class="row pt-3 pb-2">
    <div class="col-12">
        Welcome to montage/// bla-bla-bla

    </div>
</div>
<div class="row mb-4">
    <div class="col-md-6 col-lg-6 col-sm-12">
        <div class="">
            <div id="image-preview" class="position-relative">
                <video id="video" class="webcam" autoplay muted hidden></video>
                <canvas id="image-main" class="bg-light w-100"></canvas>
                <canvas id="image-decoration" class="w-100"></canvas>
            </div>
            <button class="btn btn-danger w-100 shadow-none" id="btn_photo">Select one effect</button>
        </div>
    </div>
    <div class="col-md-6 col-lg-6 col-sm-12">
        <div class="w-100">
            <form id="decoration-settings">
                <span class="text-success">Decoration settings</span>
                <div>
                    <label>Width: </label>
                    <input class="pl-1" type="range" name="setWidth" min="0" max="150" value="100">
                    <span>100%</span>
                </div>
                <div>
                    <span>Height: </span>
                    <input class="pl-1" type="range" name="setHeight" min="0" max="150" value="100">
                    <span>100%</span>
                </div>
                <div>
                    <span>Move horizontally: </span>
                    <input class="pl-1 small" type="number" name="setOX" value="0" style="max-width: 50px">
                    <span>px</span>
                </div>
                <div>
                    <span>Move vertically: </span>
                    <input class="pl-1 small" type="number" name="setOY" value="0" style="max-width: 50px">
                    <span>px</span>
                </div>
            </form>
        </div>
        <hr class="mb-1">
        <div class="pl-3 pb-1">
            <span class="text-success">Decorations</span>
        </div>
        <form id="decoration">
            <div class="custom-radio">
                <label  onclick="drawDecoration(this);">
                    <input type="radio" name="btn_radio">
                    <img src="/public/img/border-2.png" style="max-width: 200px; max-height: 100px;"
                         class="img-thumbnail">
                </label>
            </div>
            <div class="custom-radio">
                <label  onclick="drawDecoration(this);">
                    <input type="radio" name="btn_radio">
                    <span>imq2</span>
                </label>
            </div>
        </form>
    </div>
</div>

<script src="/public/scripts/webcam.js"></script>