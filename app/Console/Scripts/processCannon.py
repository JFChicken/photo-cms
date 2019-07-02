import os
from PIL import Image

storage = "/Users/jfc/Code/photo-cms/storage/app/public/HOTEL"

print("looking for files...")
for root, dirs, files in os.walk(storage, topdown=False):

    print("info from storage: ",files)
    for info in files:
        print("file info",info)
        command = "exiftool {}/{}".format(storage,info)
        fileInfo = os.system(command)
        print(fileInfo)
   # take files and get the file info.....
#   fileInfo = os.system('exiftool FilePng.png')

#print(fileInfo)

#print("you are here", yourpath)
#for root, dirs, files in os.walk(yourpath, topdown=False):

#	print("info",dirs)
#	for name in files:
#		print(os.path.join(root, name))
#         im = Image.open(os.path.join(root, name))
#         print("Generating png for %s" % name)
#         print(im.info)
exit()


