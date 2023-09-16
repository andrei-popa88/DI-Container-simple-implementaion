<?php

namespace Andreip\Dicontainer;

class Container {
    private array $parameterBinding = [];
    protected array $abstractBinding = [];
    private array $instances = [];

    public function bindAbstract(string $abstract, string $concrete): self {
        $this->abstractBinding[$abstract] = $concrete;

        return $this;
    }

    public function bindParameters(string $concrete, array $parameters): self {
        foreach($parameters as $paramKey => $paramValue) {
            $this->parameterBinding[$concrete][$paramKey] = $paramValue;
        }

        return $this;
    }

    private function makeReflectionClass(string $class) : \ReflectionClass {
        $reflectionClass = new \ReflectionClass($class);
        if($reflectionClass->isInterface() || $reflectionClass->isAbstract()) {
            if(!array_key_exists($reflectionClass->getName(), $this->abstractBinding )) {
                throw new \Exception("Trying to bind class {$reflectionClass->getName()} but no binding for it was defined");
            }
            $reflectionClass = new \ReflectionClass($this->abstractBinding[$reflectionClass->getName()]);
        }

        if(!$reflectionClass->isInstantiable()) {
            throw new \Exception("Class {$class} is not instantiable");
        }

        return $reflectionClass;
    }

    public function make(string $class) {
        $reflectionClass = $this->makeReflectionClass($class);
        $constructor = $reflectionClass->getConstructor();
        if(null === $constructor) {
            return $reflectionClass->newInstance();
        }

        $parameters = $constructor->getParameters();

        foreach($parameters as $parameter) {
            $type = $this->getParameterClassName($parameter);
            if(null !== $type) {
                $this->instances[$class][] = $this->make($parameter->getType()->getName());
                continue;
            }

            $name = "$".$parameter->getName();

            if(!array_key_exists($name, $this->parameterBinding[$class])) {
                if($parameter->isOptional()) {
                    continue;
                }
                throw new \Exception("No parameter bound for class $class, expecting parameter with name $name but no matches were found");
            }

            $this->instances[$class][] = $this->parameterBinding[$class][$name];
        }

        return $reflectionClass->newInstance(...$this->instances[$class]);
    }

    private function getParameterClassName($parameter): ?string
    {
        $type = $parameter->getType();

        if (! $type instanceof \ReflectionNamedType || $type->isBuiltin()) {
            return null;
        }

        return $type->getName();
    }
}