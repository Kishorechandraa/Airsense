import sys
import pandas as pd
from sklearn import linear_model

df = pd.read_csv('ML/AQI.csv')
x=df.iloc[:,2:14].values
y=df.iloc[:,-2].values

model=linear_model.LinearRegression()
model.fit(x, y)

input1 = float(sys.argv[1])
input2 = float(sys.argv[2])
input3 = float(sys.argv[3]) 
input4 = float(sys.argv[4])
input5 = float(sys.argv[5])
input6 = float(sys.argv[6])
input7 = float(sys.argv[7])
input8 = float(sys.argv[8])
input9 = float(sys.argv[9])
input10 = float(sys.argv[10])
input11 = float(sys.argv[11])
input12 = float(sys.argv[12])

prediction = model.predict([[input1, input2, input3, input4, input5, input6, input7, input8, input9, input10, input11, input12]])[0]
print(round(prediction, 2))