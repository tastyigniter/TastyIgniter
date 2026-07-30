<div class="row mx-auto px-3 my-3">
    @foreach (['quality', 'service', 'delivery'] as $ratingType)
        <div @class(['col-md-4', 'ps-md-0' => $loop->first, 'pe-md-0' => $loop->last])>
            <div class="card shadow-sm">
                <div class="card-body">
                    <div
                        class="chart-container"
                        data-control="review-chart"
                        data-data='@json($this->getController()->makeAverageRatingDataset($ratingType, $this->records))'
                    >
                        <div class="chart-canvas">
                            <canvas
                                style="width: 100%; height: 128px"
                            ></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
