import numpy as np
from flask import Flask, jsonify, request
from keras.preprocessing import image

app = Flask(__name__)
app.config['UPLOAD_EXTENSIONS'] = ['.jpg', '.png']


@app.route('/blight-analyzer', methods=['POST'])
def predictor():

    return "Online"


if __name__ == '__main__':
    app.debug = True
    app.run()
