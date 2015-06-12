#include <stdio.h>

int main(){
    printf("%d",cac(2,10));
}

int cac(x,i){
    if(i==1){
        return x;
    }else{
        return x*(cac(x,i-1)+1);
    }
}


