import sys
from PIL import Image
from resizeimage import resizeimage

try:
    arrayString = sys.argv[1].split(",")

    final = []

    for i in range(len(arrayString)):
        final.append(arrayString[i].split("--"))

    # Open the given sent file
    with open(final[0][1], 'r+b') as f:
        with Image.open(f) as image:
            cover = resizeimage.resize_cover(image, [250, 200])
            
            cover.save(final[1][1], image.format)
except Exception as e:
    print("Execption: " + str(e))
    print("id: ",final[1][1],":false")

else:
    print("id: ",final[2][1],":true")
