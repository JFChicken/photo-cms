import sys
import random
from PIL import Image
from resizeimage import resizeimage

try:
    arrayString = sys.argv[1].split(",")

    final = []

    for i in range(len(arrayString)):
        final.append(arrayString[i].split("--"))

    
    
    rootDir = final[0][1]
    # look at this folder and create a csv of the data needed for the files and also create full size images to latter be converted to thumbnails
    # i will move these photos to a photo dir so they can be proceesed by current functions
    

except Exception as e:
    print("Execption: " + str(e))
    print("false")

else:
    print("true")
