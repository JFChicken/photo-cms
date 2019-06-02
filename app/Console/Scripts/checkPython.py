from importlib import util
check = util.find_spec("PIL")

print ('Pillow:')

if check is not None:
    print ('PIL is installed ')
else:
    print('PIL is not installed')

print('resize image')
check = util.find_spec("resizeimage")
if check is not None:
    print ('resizeimage is installed ')
else:
    print('resizeimage is not installed')