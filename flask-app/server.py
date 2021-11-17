from flask import Flask, request


app = Flask(__name__)
app.config['UPLOAD_EXTENSIONS'] = ['.jpg', '.png']


@app.route('/')
def home():
    return "Flask running"


@app.route('/disease-analyzer', methods=['POST'])
def tb():
    plant_image = request.json['img']

    response = "File received : " + plant_image  # model.predict(img_arr)

    return response


if __name__ == '__main__':
    app.run(host='0.0.0.0', debug=True, port=4040)
