#include <stdio.h>
#include <stdlib.h>
#include <string.h>
int fib(int N);
int fibonacci(int N,int *name);
int fib1(int N);
int fib2(int N);


int main(){
    int N;
    scanf("%d",&N);
    printf("%d\n",fib(N));
    printf("%d\n",fib1(N));
    printf("%d\n",fib2(N));
}

int fib(int N){
    return N<2?N:fib(N-1)+fib(N-2);
}

int fib1(int N){
    int* res = (int *)malloc( (N+1)*sizeof(int) );
    memset(res,0,(N+1)*sizeof(int));
    return  fibonacci(N,res);
}

int fibonacci(int N,int *name){
    if(N<2) return N;
    if(name[N]==0){
        name[N] = fibonacci(N-1,name)+fibonacci(N-2,name);
    }
    return name[N];
}

int fib2(int N){
    if(N<2) return N;
    int* res = (int *)malloc( (N+1)*sizeof(int) );
    memset(res,0,(N+1)*sizeof(int));
    res[1]= 1;
    int i=2;
    while(i<=N){
        res[i]=res[i-1]+res[i-2];
        i++;
    }
    return  res[N];
}

