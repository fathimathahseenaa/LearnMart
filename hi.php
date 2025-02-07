<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback & Reviews</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
   body {
    font-family: Arial, sans-serif;
    background: #f9f9f9;
    margin: 0;
    padding: 20px;
}

/* Add some margin on the sides */
.container {
    max-width: 80%;
    margin: 0 auto;
}

.title {
    font-size: 22px;
    margin-bottom: 10px;
    text-align: left;
}

/* Layout for Ratings and Reviews */
.review-section {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    width: 100%;
}

/* Left: Ratings Summary */
.rating-summary {
    width: 30%;
}

.average-rating {
    font-size: 24px;
    font-weight: bold;
    color: #ff9800;
}

.total-reviews {
    font-size: 14px;
    color: gray;
    display: block;
    margin-bottom: 10px;
}

.rating-bars {
    width: 100%;
}

.rating-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 14px;
    margin: 5px 0;
}

.bar {
    width: 50%;
    height: 8px;
    background: #ddd;
    border-radius: 5px;
    margin: 0 10px;
    overflow: hidden;
}

.fill {
    height: 100%;
    background: #007BFF;
    border-radius: 5px;
}

/* Right: Reviews */
.reviews {
    width: 65%;
}

.review {
    display: flex;
    background: #ffffff;
    margin: 10px 0;
    padding: 10px;
    border-bottom: 1px solid #ddd;
    align-items: center;
}

.user-initial {
    width: 40px;
    height: 40px;
    background: #007BFF;
    color: white;
    font-size: 18px;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    margin-right: 10px;
}

.review-content {
    flex: 1;
}

.user-name {
    font-weight: bold;
}

.review-rating {
    font-size: 14px;
    color: gray;
    margin-bottom: 5px;
}

p {
    margin: 0;
}

.view-more {
    display: block;
    text-align: right;
    margin-top: 10px;
    color: #007BFF;
    text-decoration: none;
    font-weight: bold;
}

/* Responsive */
@media (max-width: 1024px) {
    .container {
        max-width: 90%;
    }
}

@media (max-width: 768px) {
    .review-section {
        flex-direction: column;
        align-items: center;
    }

    .rating-summary, .reviews {
        width: 100%;
        text-align: center;
    }

    .rating-row {
        justify-content: center;
    }
}
</style>
<body>
<div class="container">
        <h2 class="title">Learner Reviews</h2>
        <div class="review-section">
            <!-- Left: Ratings Summary -->
            <div class="rating-summary">
                <span class="average-rating">⭐ 4.7</span>
                <span class="total-reviews">317 reviews</span>
                <div class="rating-bars">
                    <div class="rating-row">
                        <span>5 stars</span>
                        <div class="bar"><div class="fill" style="width: 82%;"></div></div>
                        <span>82.37%</span>
                    </div>
                    <div class="rating-row">
                        <span>4 stars</span>
                        <div class="bar"><div class="fill" style="width: 13%;"></div></div>
                        <span>13.37%</span>
                    </div>
                    <div class="rating-row">
                        <span>3 stars</span>
                        <div class="bar"><div class="fill" style="width: 2%;"></div></div>
                        <span>2.43%</span>
                    </div>
                    <div class="rating-row">
                        <span>2 stars</span>
                        <div class="bar"><div class="fill" style="width: 1%;"></div></div>
                        <span>0.91%</span>
                    </div>
                    <div class="rating-row">
                        <span>1 star</span>
                        <div class="bar"><div class="fill" style="width: 1%;"></div></div>
                        <span>0.91%</span>
                    </div>
                </div>
            </div>

            <!-- Right: Reviews List -->
             
            <div class="reviews">
                <div class="review">
                    <div class="user-initial">Y</div>
                    <div class="review-content">
                        <div class="user-name">YE</div>
                        <div class="review-rating">⭐ 5 • Reviewed on Dec 2, 2024</div>
                        <p>An excellent course. The instructors presented the course very well. I have learnt a lot.</p>
                    </div>
                </div>

                <div class="review">
                    <div class="user-initial">M</div>
                    <div class="review-content">
                        <div class="user-name">MP</div>
                        <div class="review-rating">⭐ 5 • Reviewed on Jan 22, 2025</div>
                        <p>I really appreciate the form and quiz. Final PDF summary of the course received at the end is very useful. I highly recommend this training.</p>
                    </div>
                </div>

                <div class="review">
                    <div class="user-initial">A</div>
                    <div class="review-content">
                        <div class="user-name">AK</div>
                        <div class="review-rating">⭐ 5 • Reviewed on Nov 10, 2024</div>
                        <p>The only component missing is free access to Generative AI tools during the course.</p>
                    </div>
                </div>
            </div>
        </div>

        <a href="#" class="view-more">View more reviews</a>
    </div>
</body>
</html>
